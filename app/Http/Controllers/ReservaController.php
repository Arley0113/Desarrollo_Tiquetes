<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Vuelo;
use App\Models\Pasajero;
use App\Models\Asiento;
use App\Services\ReservaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    protected $reservaService;

    public function __construct(ReservaService $reservaService)
    {
        $this->reservaService = $reservaService;
    }

    /**
     * Ver mis reservas
     */
    public function index()
    {
        // Intentar reclamar reservas huérfanas (sin usuario) por correo del pago
        if (Auth::check()) {
            try {
                Reserva::whereNull('id_usuario')
                    ->whereHas('pagos', function ($q) {
                        $q->where('correo', Auth::user()->correo);
                    })
                    ->update(['id_usuario' => Auth::user()->id_usuario]);
            } catch (\Throwable $e) {
                // No interrumpir la vista si falla el reclamo; solo registrar si es necesario
                \Log::warning('No se pudo reclamar reservas por correo', [
                    'user_id' => Auth::user()->id_usuario ?? null,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $reservas = Reserva::with([
                'vuelo.origen',
                'vuelo.destino',
                'vuelo.precio',
                'pasajeros',
                'tiquetes.asiento',
                'pagos'
            ])
            ->where('id_usuario', Auth::user()->id_usuario)
            ->orderBy('fecha_reserva', 'desc')
            ->paginate(10);

        return view('reservas.index', compact('reservas'));
    }

    /**
     * Vista inicial: información de pasajeros
     */
    public function create($id_vuelo)
    {
        $vuelo = Vuelo::with(['origen', 'destino', 'precio', 'avion'])->findOrFail($id_vuelo);
        
        // Verificar que hay asientos disponibles
        if ($vuelo->asientosDisponibles() <= 0) {
            return redirect()->back()->withErrors(['error' => 'No hay asientos disponibles para este vuelo.']);
        }

        return view('reservas.pasajeros', compact('vuelo'));
    }

    /**
     * Guardar información de pasajeros y redirigir a selección de asientos
     */
    public function guardarPasajeros(Request $request)
    {
        $request->validate([
            'id_vuelo' => 'required|exists:vuelos,id_vuelo',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email',
            'telefono' => 'required|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:masculino,femenino,otro',
        ]);

        // Guardar datos en sesión temporalmente
        session([
            'reserva_temp' => [
                'id_vuelo' => $request->id_vuelo,
                'pasajero_principal' => [
                    'nombre' => $request->nombre . ' ' . $request->apellido,
                    'email' => $request->email,
                    'telefono' => $request->telefono,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'genero' => $request->genero,
                ]
            ]
        ]);

        // Redirigir a selección de asientos
        return redirect()->route('reservas.asientos.seleccionar', [
            'vuelo' => $request->id_vuelo,
            'cantidad' => 1 // Por ahora solo 1 pasajero
        ]);
    }

    /**
     * Vista de selección de asientos
     */
    public function seleccionarAsientos($id_vuelo, Request $request)
    {
        $vuelo = Vuelo::with(['origen', 'destino', 'precio', 'avion'])->findOrFail($id_vuelo);
        
        $cantidadPasajeros = $request->get('cantidad', 1);
        
        // Verificar que hay suficientes asientos
        if ($vuelo->asientosDisponibles() < $cantidadPasajeros) {
            return redirect()->route('vuelo.mostrar', $id_vuelo)
                ->withErrors(['error' => 'No hay suficientes asientos disponibles.']);
        }

        // Obtener asientos del avión agrupados por fila
        $asientos = Asiento::where('id_avion', $vuelo->id_avion)
            ->ordenados()
            ->get()
            ->groupBy('fila');

        // Obtener asientos ya ocupados para este vuelo
        $asientosOcupados = DB::table('tiquetes')
            ->where('id_vuelo', $id_vuelo)
            ->pluck('id_asiento')
            ->toArray();

        // Marcar asientos como ocupados
        foreach ($asientos as $fila => $asientosFila) {
            foreach ($asientosFila as $asiento) {
                if (in_array($asiento->id_asiento, $asientosOcupados)) {
                    $asiento->estado = 'ocupado';
                }
            }
        }

        $reservaTemp = session('reserva_temp');

        return view('reservas.seleccionar_asientos', compact(
            'vuelo',
            'asientos',
            'cantidadPasajeros',
            'reservaTemp'
        ));
    }

    /**
     * Guardar asientos seleccionados y crear reserva
     */
    public function guardarAsientos(Request $request, $id_vuelo)
    {
        $request->validate([
            'asientos' => 'required|json',
        ]);

        $asientosIds = json_decode($request->asientos, true);
        if (!is_array($asientosIds) || count($asientosIds) < 1) {
            return back()->withErrors(['Debes seleccionar al menos 1 asiento.']);
        }

        $reservaTemp = session('reserva_temp');

        // Construir pasajeros aún si no hay sesión (mejor UX)
        if ($reservaTemp && ($reservaTemp['id_vuelo'] ?? null) == $id_vuelo) {
            $pasajeros = [
                [
                    'nombre' => $reservaTemp['pasajero_principal']['nombre'] ?? 'Invitado',
                    'documento' => $reservaTemp['pasajero_principal']['documento'] ?? null,
                    'acompanante' => false,
                ]
            ];
        } else {
            // Fallback: si hay usuario autenticado, usar sus datos; si no, datos genéricos
            $nombre = 'Invitado';
            $documento = null;
            if (Auth::check()) {
                $u = Auth::user();
                $nombre = trim(($u->nombres ?? '') . ' ' . ($u->primer_apellido ?? '')) ?: 'Invitado';
                $documento = $u->documento ?? null;
            }
            $pasajeros = [[
                'nombre' => $nombre,
                'documento' => $documento,
                'acompanante' => false,
            ]];
        }

        try {
            // Verificar disponibilidad usando el servicio
            if (!$this->reservaService->verificarDisponibilidadAsientos($id_vuelo, $asientosIds)) {
                return back()->withErrors(['Algunos asientos ya no están disponibles.']);
            }

            // Crear reserva usando el servicio
            $usuarioId = Auth::check() ? Auth::user()->id_usuario : null;
            $reserva = $this->reservaService->crearReservaCompleta(
                $usuarioId,
                $id_vuelo,
                $pasajeros,
                $asientosIds
            );

            // Calcular precio total usando el servicio
            $precioTotal = $this->reservaService->calcularPrecioTotal($id_vuelo, $asientosIds);

            // Guardar precio en sesión para el pago
            session(['precio_total' => $precioTotal]);

            // Limpiar sesión temporal
            session()->forget('reserva_temp');

            return redirect()->route('pagos.create', $reserva->id_reserva)
                ->with('success', 'Asientos seleccionados. Procede al pago.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    /**
     * Ver mis reservas
     */
    public function misReservas()
    {
        $reservas = Reserva::with(['vuelo.origen', 'vuelo.destino', 'pasajeros'])
            ->where('id_usuario', Auth::user()->id_usuario)
            ->orderBy('fecha_reserva', 'desc')
            ->paginate(10);

        return view('reservas.mis_reservas', compact('reservas'));
    }

    /**
     * Cancelar reserva
     */
    public function cancelar($id_reserva)
    {
        try {
            $this->reservaService->cancelarReserva($id_reserva, Auth::user()->id_usuario);
            return back()->with('success', 'Reserva cancelada exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cancelar: ' . $e->getMessage()]);
        }
    }

        //////////////////////////////////////////

    /**
     * Mostrar confirmación de reserva
     */
    public function confirmacion($id)
    {
        $reserva = Reserva::with([
            'vuelo.origen', 
            'vuelo.destino', 
            'pasajeros', 
            'tiquetes.asiento',
            'pagos'
        ])->findOrFail($id);

        return view('reservas.confirmacion', compact('reserva'));
    }

    /**
     * Mostrar detalles de reserva
     */
    public function mostrar($id)
    {
        $reserva = Reserva::with('vuelo')->findOrFail($id);
        return view('reserva.mostrar', compact('reserva'));
    }
}



    



<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Vuelo;
use App\Models\Pasajero;
use App\Services\ReservaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    protected $reservaService;

    public function __construct(ReservaService $reservaService)
    {
        $this->reservaService = $reservaService;
    }

    // Crear reserva (vista)
    public function create($id_vuelo)
    {
        $vuelo = Vuelo::with(['origen', 'destino', 'precio'])->findOrFail($id_vuelo);
        return view('reservas.crear', compact('vuelo'));
    }

    // Guardar reserva y pasajeros
    public function store(Request $request)
    {
        $request->validate([
            'id_vuelo' => 'required|exists:vuelos,id_vuelo',
            'pasajeros' => 'required|array|min:1',
            'pasajeros.*.nombre' => 'required|string',
            'pasajeros.*.documento' => 'required|string'
        ]);

        $reserva = $this->reservaService->crearReserva(Auth::id(), $request->id_vuelo, $request->pasajeros);

        return redirect()->route('pagos.create', $reserva->id_reserva)
            ->with('success', 'Reserva creada correctamente. Continúa con el pago.');
    }
}

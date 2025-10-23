<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Services\PagoService;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    protected $pagoService;

    public function __construct(PagoService $pagoService)
    {
        $this->pagoService = $pagoService;
    }

    public function create($id_reserva)
    {
        $reserva = Reserva::with(['vuelo.origen', 'vuelo.destino', 'vuelo.precio'])->findOrFail($id_reserva);
        if (!$reserva->vuelo) {
            \Log::warning('Reserva sin vuelo al cargar pagos.create', [
                'id_reserva' => $id_reserva,
                'id_vuelo' => $reserva->id_vuelo ?? null,
            ]);
        }
        return view('pagos.create', compact('reserva'));
    }

    public function store(Request $request, $id_reserva)
    {
        $request->validate([
            'nombre_titular' => 'required|string',
            'tipo_documento' => 'required|string',
            'documento' => 'required|string',
            'correo' => 'required|email',
            'telefono' => 'required|string',
            'medio_pago' => 'required|in:Tarjeta de crédito,Tarjeta débito,PSE',
            'monto' => 'required|numeric|min:0'
        ]);

        $pago = $this->pagoService->procesarPago($id_reserva, $request->all());

        return redirect()->route('tiquetes.generar', $id_reserva)
            ->with('success', 'Pago procesado correctamente.');
    }
}

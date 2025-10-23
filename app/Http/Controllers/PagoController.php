<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Services\PagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    protected $pagoService;

    public function __construct(PagoService $pagoService)
    {
        $this->pagoService = $pagoService;
    }

    public function create($id_reserva)
    {
        $reserva = Reserva::with(['vuelo.origen', 'vuelo.destino', 'tiquetes.asiento', 'pagos'])
            ->findOrFail($id_reserva);

        $precioTotal = session('precio_total');

        return view('pagos.create', compact('reserva', 'precioTotal'));
    }

    public function store(Request $request, $id_reserva)
    {
        $request->validate([
            'metodo_pago' => 'required|string',
            'correo' => 'required|email',
        ]);

        $reserva = Reserva::findOrFail($id_reserva);

        // Asociar reserva con el usuario autenticado si aún no tiene
        if (auth()->check() && empty($reserva->id_usuario)) {
            $reserva->id_usuario = auth()->user()->id_usuario;
            $reserva->save();
        }

        $pago = $this->pagoService->procesarPago($reserva, [
            'metodo_pago' => $request->metodo_pago,
            'correo' => $request->correo,
        ]);

        return redirect()->route('tiquetes.generar', $reserva->id_reserva)
            ->with('success', 'Pago procesado correctamente. Generando tiquetes...');
    }
}

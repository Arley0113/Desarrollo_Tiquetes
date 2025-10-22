<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Services\TiqueteService;
use Illuminate\Http\Request;

class TiqueteController extends Controller
{
    protected $tiqueteService;

    public function __construct(TiqueteService $tiqueteService)
    {
        $this->tiqueteService = $tiqueteService;
    }

    public function generar($id_reserva)
    {
        $reserva = Reserva::with(['vuelo', 'pasajeros'])->findOrFail($id_reserva);
        $this->tiqueteService->generarTiquetes($reserva);

        return view('reservas.confirmacion', compact('reserva'))
            ->with('success', 'Tiquetes generados exitosamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Tiquete;
use App\Services\TiqueteService;
use Illuminate\Http\Request;

class TiqueteController extends Controller
{
    protected $tiqueteService;

    public function __construct(TiqueteService $tiqueteService)
    {
        $this->tiqueteService = $tiqueteService;
    }

    public function index()
    {
        $tiquetes = Tiquete::with(['reserva.vuelo.origen', 'reserva.vuelo.destino', 'asiento'])
            ->whereHas('reserva', function ($q) {
                $q->where('id_usuario', auth()->user()->id_usuario);
            })
            ->orderByDesc('id_tiquete')
            ->paginate(10);

        return view('tiquetes.index', compact('tiquetes'));
    }

    public function show($id)
    {
        $tiquete = Tiquete::with(['reserva.vuelo.origen', 'reserva.vuelo.destino', 'asiento'])
            ->whereHas('reserva', function ($q) {
                $q->where('id_usuario', auth()->user()->id_usuario);
            })
            ->findOrFail($id);

        return view('tiquetes.show', compact('tiquete'));
    }

    public function generar($id_reserva)
    {
        $reserva = Reserva::with(['pasajeros', 'vuelo.precio'])->findOrFail($id_reserva);

        if (auth()->check() && empty($reserva->id_usuario)) {
            $reserva->id_usuario = auth()->user()->id_usuario;
            $reserva->save();
        }

        $tiquetes = $this->tiqueteService->generarTiquetes($reserva);

        return redirect()->route('tiquetes.index')
            ->with('success', 'Tiquetes generados correctamente.');
    }
}

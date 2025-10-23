<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Tiquete;
use App\Services\TiqueteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiqueteController extends Controller
{
    protected $tiqueteService;

    public function __construct(TiqueteService $tiqueteService)
    {
        $this->tiqueteService = $tiqueteService;
    }

    /**
     * Ver mis tiquetes
     */
    public function index()
    {
        $tiquetes = Tiquete::with(['vuelo.origen', 'vuelo.destino', 'asiento', 'pasajero'])
            ->whereHas('reserva', function($query) {
                $query->where('id_usuario', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tiquetes.index', compact('tiquetes'));
    }

    /**
     * Generar tiquetes para una reserva
     */
    public function generar($id_reserva)
    {
        $reserva = Reserva::with(['vuelo', 'pasajeros'])->findOrFail($id_reserva);
        $this->tiqueteService->generarTiquetes($reserva);

        return view('reservas.confirmacion', compact('reserva'))
            ->with('success', 'Tiquetes generados exitosamente.');
    }

    /**
     * Ver detalles de un tiquete
     */
    public function show($id)
    {
        $tiquete = Tiquete::with(['vuelo.origen', 'vuelo.destino', 'asiento', 'pasajero', 'reserva'])
            ->whereHas('reserva', function($query) {
                $query->where('id_usuario', Auth::id());
            })
            ->findOrFail($id);

        return view('tiquetes.show', compact('tiquete'));
    }

    /**
     * Descargar tiquete
     */
    public function descargar($id)
    {
        $tiquete = Tiquete::with(['vuelo.origen', 'vuelo.destino', 'asiento', 'pasajero', 'reserva'])
            ->whereHas('reserva', function($query) {
                $query->where('id_usuario', Auth::id());
            })
            ->findOrFail($id);

        // Aquí implementarías la lógica para generar y descargar el PDF
        // Por ahora solo redirigimos a la vista
        return view('tiquetes.show', compact('tiquete'))
            ->with('success', 'Tiquete listo para descargar.');
    }
}

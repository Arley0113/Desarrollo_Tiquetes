<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Vuelo;
use App\Models\Reserva;
use App\Models\Pago;
use App\Models\Tiquete;

class AdminController extends Controller
{
    // Dashboard principal
    public function index()
    {
        $totalUsuarios = Usuario::count();
        $totalVuelos = Vuelo::count();
        $totalReservas = Reserva::count();
        $totalPagos = Pago::count();
        $totalTiquetes = Tiquete::count();

        $ingresos = Pago::sum('monto');

        $ultimasReservas = Reserva::with('usuario')
            ->orderByDesc('fecha_reserva')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsuarios',
            'totalVuelos',
            'totalReservas',
            'totalPagos',
            'totalTiquetes',
            'ingresos',
            'ultimasReservas'
        ));
    }

    // Gestión de vuelos
    public function vuelos()
    {
        $vuelos = Vuelo::with(['origen', 'destino', 'avion'])->get();
        return view('admin.vuelos', compact('vuelos'));
    }

    // Reporte de ventas
    public function reportes()
    {
        $pagos = Pago::with('reserva.usuario')->orderByDesc('fecha_pago')->get();
        return view('admin.reportes', compact('pagos'));
    }
}

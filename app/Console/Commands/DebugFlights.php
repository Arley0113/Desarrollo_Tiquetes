<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vuelo;
use App\Models\Lugar;

class DebugFlights extends Command
{
    protected $signature = 'debug:flights';
    protected $description = 'Debug flight data';

    public function handle()
    {
        $this->info('=== DEBUG FLIGHTS ===');
        
        // Total vuelos
        $totalVuelos = Vuelo::count();
        $this->info("Total vuelos: {$totalVuelos}");
        
        // Lugares disponibles
        $lugares = Lugar::all();
        $this->info("\nLugares disponibles:");
        foreach ($lugares as $lugar) {
            $this->line("ID: {$lugar->id_lugar} - {$lugar->nombre_lugar}");
        }
        
        // Algunos vuelos de ejemplo
        $this->info("\nPrimeros 5 vuelos:");
        $vuelos = Vuelo::with(['origen', 'destino', 'avion', 'precio'])->take(5)->get();
        foreach ($vuelos as $vuelo) {
            $this->line("Vuelo {$vuelo->id_vuelo}: {$vuelo->origen->nombre_lugar} -> {$vuelo->destino->nombre_lugar}");
            $this->line("  Fecha: {$vuelo->fecha_vuelo}");
            $this->line("  Hora: {$vuelo->hora}");
            $this->line("  Avión: " . ($vuelo->avion ? $vuelo->avion->nombre_avion : 'Sin avión'));
            $this->line("  Precio: " . ($vuelo->precio ? '$' . number_format($vuelo->precio->precio_ida) : 'Sin precio'));
            $this->line("---");
        }
        
        // Verificar fechas
        $this->info("\nFechas disponibles:");
        $fechas = Vuelo::select('fecha_vuelo')->distinct()->orderBy('fecha_vuelo')->get();
        foreach ($fechas as $fecha) {
            $this->line($fecha->fecha_vuelo);
        }
        
        // Verificar rutas específicas
        $this->info("\nRutas Bogotá -> Medellín:");
        $rutas = Vuelo::with(['origen', 'destino'])
            ->whereHas('origen', function($q) { $q->where('nombre_lugar', 'Bogotá'); })
            ->whereHas('destino', function($q) { $q->where('nombre_lugar', 'Medellín'); })
            ->get();
        
        $this->info("Encontrados: " . $rutas->count() . " vuelos");
        foreach ($rutas->take(3) as $ruta) {
            $this->line("Fecha: {$ruta->fecha_vuelo} - Hora: {$ruta->hora}");
        }
        
        // Verificar vuelos de hoy
        $hoy = now()->format('Y-m-d');
        $this->info("\nVuelos para hoy ({$hoy}):");
        $vuelosHoy = Vuelo::whereDate('fecha_vuelo', $hoy)->with(['origen', 'destino'])->get();
        $this->info("Encontrados: " . $vuelosHoy->count() . " vuelos");
        foreach ($vuelosHoy->take(5) as $vuelo) {
            $this->line("{$vuelo->origen->nombre_lugar} -> {$vuelo->destino->nombre_lugar} ({$vuelo->hora})");
        }
    }
}
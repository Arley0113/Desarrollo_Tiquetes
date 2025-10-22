<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vuelo;
use App\Models\Lugar;

class TestSearch extends Command
{
    protected $signature = 'test:search';
    protected $description = 'Test flight search';

    public function handle()
    {
        $this->info('=== TESTING FLIGHT SEARCH ===');
        
        // Simular búsqueda Bogotá -> Medellín para hoy
        $origen = Lugar::where('nombre_lugar', 'Bogotá')->first();
        $destino = Lugar::where('nombre_lugar', 'Medellín')->first();
        $fecha = now()->format('Y-m-d');
        
        $this->info("Buscando: {$origen->nombre_lugar} -> {$destino->nombre_lugar} para {$fecha}");
        $this->info("Origen ID: {$origen->id_lugar}, Destino ID: {$destino->id_lugar}");
        
        // Buscar vuelos
        $vuelos = Vuelo::with(['origen', 'destino', 'avion', 'precio'])
            ->whereDate('fecha_vuelo', $fecha)
            ->where('id_origen', $origen->id_lugar)
            ->where('id_destino', $destino->id_lugar)
            ->get();
        
        $this->info("Vuelos encontrados: " . $vuelos->count());
        
        foreach ($vuelos as $vuelo) {
            $this->line("Vuelo {$vuelo->id_vuelo}: {$vuelo->hora} - $" . number_format($vuelo->precio->precio_ida ?? 0));
        }
        
        // Si no hay vuelos, buscar para cualquier fecha
        if ($vuelos->isEmpty()) {
            $this->info("\nBuscando para cualquier fecha...");
            $vuelosCualquierFecha = Vuelo::with(['origen', 'destino', 'avion', 'precio'])
                ->where('id_origen', $origen->id_lugar)
                ->where('id_destino', $destino->id_lugar)
                ->get();
            
            $this->info("Vuelos encontrados para cualquier fecha: " . $vuelosCualquierFecha->count());
            
            foreach ($vuelosCualquierFecha->take(3) as $vuelo) {
                $this->line("Vuelo {$vuelo->id_vuelo}: {$vuelo->fecha_vuelo} {$vuelo->hora} - $" . number_format($vuelo->precio->precio_ida ?? 0));
            }
        }
    }
}
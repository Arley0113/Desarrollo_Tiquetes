<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vuelo;
use App\Models\Lugar;
use App\Models\ModeloAvion;
use App\Models\Precio;

class CreateTestFlights extends Command
{
    protected $signature = 'flights:create-test';
    protected $description = 'Create test flights for today and tomorrow';

    public function handle()
    {
        $lugares = Lugar::all();
        $aviones = ModeloAvion::all();
        $precios = Precio::all();
        
        $today = now()->format('Y-m-d');
        $tomorrow = now()->addDay()->format('Y-m-d');
        
        $horas = ['06:00', '08:30', '11:00', '13:30', '16:00', '18:30', '21:00'];
        
        $rutas = [
            ['origen' => 'Bogotá', 'destino' => 'Medellín', 'duracion' => '1h 15m'],
            ['origen' => 'Bogotá', 'destino' => 'Cali', 'duracion' => '1h 30m'],
            ['origen' => 'Bogotá', 'destino' => 'Cartagena', 'duracion' => '1h 45m'],
            ['origen' => 'Medellín', 'destino' => 'Bogotá', 'duracion' => '1h 15m'],
            ['origen' => 'Medellín', 'destino' => 'Cali', 'duracion' => '1h 00m'],
            ['origen' => 'Cali', 'destino' => 'Bogotá', 'duracion' => '1h 30m'],
        ];
        
        $fechas = [$today, $tomorrow];
        
        foreach ($fechas as $fecha) {
            foreach ($rutas as $ruta) {
                $origen = $lugares->where('nombre_lugar', $ruta['origen'])->first();
                $destino = $lugares->where('nombre_lugar', $ruta['destino'])->first();
                
                if ($origen && $destino) {
                    // Crear 2-3 vuelos por ruta por día
                    for ($i = 0; $i < 3; $i++) {
                        $hora = $horas[array_rand($horas)];
                        $avion = $aviones->random();
                        $precio = $precios->random();
                        
                        // Calcular hora de llegada
                        $horaSalida = strtotime($hora);
                        $duracionMinutos = $this->convertirDuracionAMinutos($ruta['duracion']);
                        $horaLlegada = date('H:i', $horaSalida + ($duracionMinutos * 60));
                        
                        Vuelo::create([
                            'fecha_vuelo' => $fecha,
                            'hora' => $hora,
                            'hora_llegada' => $horaLlegada,
                            'id_origen' => $origen->id_lugar,
                            'id_destino' => $destino->id_lugar,
                            'id_avion' => $avion->id_avion,
                            'id_precio' => $precio->id_precio,
                            'duracion' => $ruta['duracion'],
                            'directo' => rand(0, 1),
                            'wifi' => rand(0, 1),
                            'reembolsable' => rand(0, 1),
                            'codigo_vuelo' => strtoupper(substr($ruta['origen'], 0, 2) . substr($ruta['destino'], 0, 2) . rand(1000, 9999)),
                        ]);
                    }
                }
            }
        }
        
        $this->info('Test flights created successfully for today and tomorrow!');
    }
    
    private function convertirDuracionAMinutos($duracion)
    {
        preg_match('/(\d+)h\s*(\d+)m/', $duracion, $matches);
        if (count($matches) === 3) {
            return ($matches[1] * 60) + $matches[2];
        }
        return 90;
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vuelo;
use App\Models\Lugar;
use App\Models\ModeloAvion;
use App\Models\Precio;

class VuelosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lugares = Lugar::all();
        $aviones = ModeloAvion::all();
        $precios = Precio::all();
        
        $rutas = [
            // Bogotá a otras ciudades
            ['origen' => 'Bogotá', 'destino' => 'Medellín', 'duracion' => '1h 15m'],
            ['origen' => 'Bogotá', 'destino' => 'Cali', 'duracion' => '1h 30m'],
            ['origen' => 'Bogotá', 'destino' => 'Cartagena', 'duracion' => '1h 45m'],
            ['origen' => 'Bogotá', 'destino' => 'Santa Marta', 'duracion' => '1h 30m'],
            ['origen' => 'Bogotá', 'destino' => 'Pereira', 'duracion' => '1h 00m'],
            ['origen' => 'Bogotá', 'destino' => 'Armenia', 'duracion' => '1h 10m'],
            ['origen' => 'Bogotá', 'destino' => 'Manizales', 'duracion' => '1h 05m'],
            ['origen' => 'Bogotá', 'destino' => 'Bucaramanga', 'duracion' => '1h 20m'],
            
            // Medellín a otras ciudades
            ['origen' => 'Medellín', 'destino' => 'Bogotá', 'duracion' => '1h 15m'],
            ['origen' => 'Medellín', 'destino' => 'Cali', 'duracion' => '1h 00m'],
            ['origen' => 'Medellín', 'destino' => 'Cartagena', 'duracion' => '1h 30m'],
            ['origen' => 'Medellín', 'destino' => 'Pereira', 'duracion' => '0h 45m'],
            
            // Cali a otras ciudades
            ['origen' => 'Cali', 'destino' => 'Bogotá', 'duracion' => '1h 30m'],
            ['origen' => 'Cali', 'destino' => 'Medellín', 'duracion' => '1h 00m'],
            ['origen' => 'Cali', 'destino' => 'Cartagena', 'duracion' => '1h 45m'],
            
            // Cartagena a otras ciudades
            ['origen' => 'Cartagena', 'destino' => 'Bogotá', 'duracion' => '1h 45m'],
            ['origen' => 'Cartagena', 'destino' => 'Medellín', 'duracion' => '1h 30m'],
            ['origen' => 'Cartagena', 'destino' => 'Santa Marta', 'duracion' => '0h 30m'],
            
            // Santa Marta a otras ciudades
            ['origen' => 'Santa Marta', 'destino' => 'Bogotá', 'duracion' => '1h 30m'],
            ['origen' => 'Santa Marta', 'destino' => 'Cartagena', 'duracion' => '0h 30m'],
            ['origen' => 'Santa Marta', 'destino' => 'Riohacha', 'duracion' => '0h 45m'],
        ];

        $horas = ['06:00', '08:30', '11:00', '13:30', '16:00', '18:30', '21:00'];
        
        foreach ($rutas as $ruta) {
            $origen = $lugares->where('nombre_lugar', $ruta['origen'])->first();
            $destino = $lugares->where('nombre_lugar', $ruta['destino'])->first();
            
            if ($origen && $destino) {
                // Crear múltiples vuelos para cada ruta
                for ($i = 0; $i < 3; $i++) {
                    $fecha = now()->addDays(rand(1, 30))->format('Y-m-d');
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
                        'directo' => rand(0, 1), // 50% probabilidad de ser directo
                        'wifi' => rand(0, 1), // 50% probabilidad de tener wifi
                        'reembolsable' => rand(0, 1), // 50% probabilidad de ser reembolsable
                        'codigo_vuelo' => strtoupper(substr($ruta['origen'], 0, 2) . substr($ruta['destino'], 0, 2) . rand(1000, 9999)),
                    ]);
                }
            }
        }
    }
    
    private function convertirDuracionAMinutos($duracion)
    {
        // Convierte formato "1h 30m" a minutos
        preg_match('/(\d+)h\s*(\d+)m/', $duracion, $matches);
        if (count($matches) === 3) {
            return ($matches[1] * 60) + $matches[2];
        }
        return 90; // Valor por defecto
    }
}

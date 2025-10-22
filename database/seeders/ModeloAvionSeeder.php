<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModeloAvion;
use App\Models\Aeropuerto;

class ModeloAvionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aeropuertos = Aeropuerto::all();
        
        $aviones = [
            ['nombre_avion' => 'Boeing 737-800', 'capacidad' => 180, 'serial' => 'B737-001'],
            ['nombre_avion' => 'Airbus A320', 'capacidad' => 150, 'serial' => 'A320-001'],
            ['nombre_avion' => 'Boeing 737-700', 'capacidad' => 140, 'serial' => 'B737-002'],
            ['nombre_avion' => 'Airbus A319', 'capacidad' => 120, 'serial' => 'A319-001'],
            ['nombre_avion' => 'Embraer E190', 'capacidad' => 100, 'serial' => 'E190-001'],
            ['nombre_avion' => 'ATR 72-600', 'capacidad' => 70, 'serial' => 'ATR72-001'],
            ['nombre_avion' => 'Bombardier CRJ900', 'capacidad' => 90, 'serial' => 'CRJ9-001'],
            ['nombre_avion' => 'Boeing 737-900', 'capacidad' => 200, 'serial' => 'B737-003'],
        ];

        foreach ($aviones as $index => $avion) {
            $avion['id_aeropuerto'] = $aeropuertos->random()->id_aeropuerto;
            ModeloAvion::create($avion);
        }
    }
}

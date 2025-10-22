<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aeropuerto;
use App\Models\Lugar;

class AeropuertoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lugares = Lugar::all();
        
        $aeropuertos = [
            ['nombre' => 'Aeropuerto El Dorado', 'detalle' => 'Principal aeropuerto de Bogotá', 'id_lugar' => $lugares->where('nombre_lugar', 'Bogotá')->first()->id_lugar],
            ['nombre' => 'Aeropuerto José María Córdova', 'detalle' => 'Aeropuerto internacional de Medellín', 'id_lugar' => $lugares->where('nombre_lugar', 'Medellín')->first()->id_lugar],
            ['nombre' => 'Aeropuerto Alfonso Bonilla Aragón', 'detalle' => 'Aeropuerto de Cali', 'id_lugar' => $lugares->where('nombre_lugar', 'Cali')->first()->id_lugar],
            ['nombre' => 'Aeropuerto Ernesto Cortissoz', 'detalle' => 'Aeropuerto de Barranquilla', 'id_lugar' => $lugares->where('nombre_lugar', 'Barranquilla')->first()->id_lugar],
            ['nombre' => 'Aeropuerto Rafael Núñez', 'detalle' => 'Aeropuerto de Cartagena', 'id_lugar' => $lugares->where('nombre_lugar', 'Cartagena')->first()->id_lugar],
            ['nombre' => 'Aeropuerto Simón Bolívar', 'detalle' => 'Aeropuerto de Santa Marta', 'id_lugar' => $lugares->where('nombre_lugar', 'Santa Marta')->first()->id_lugar],
            ['nombre' => 'Aeropuerto Matecaña', 'detalle' => 'Aeropuerto de Pereira', 'id_lugar' => $lugares->where('nombre_lugar', 'Pereira')->first()->id_lugar],
            ['nombre' => 'Aeropuerto El Edén', 'detalle' => 'Aeropuerto de Armenia', 'id_lugar' => $lugares->where('nombre_lugar', 'Armenia')->first()->id_lugar],
            ['nombre' => 'Aeropuerto La Nubia', 'detalle' => 'Aeropuerto de Manizales', 'id_lugar' => $lugares->where('nombre_lugar', 'Manizales')->first()->id_lugar],
            ['nombre' => 'Aeropuerto Palonegro', 'detalle' => 'Aeropuerto de Bucaramanga', 'id_lugar' => $lugares->where('nombre_lugar', 'Bucaramanga')->first()->id_lugar],
        ];

        foreach ($aeropuertos as $aeropuerto) {
            Aeropuerto::create($aeropuerto);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lugar;

class LugaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lugares = [
            ['nombre_lugar' => 'Bogotá'],
            ['nombre_lugar' => 'Medellín'],
            ['nombre_lugar' => 'Cali'],
            ['nombre_lugar' => 'Barranquilla'],
            ['nombre_lugar' => 'Cartagena'],
            ['nombre_lugar' => 'Santa Marta'],
            ['nombre_lugar' => 'Pereira'],
            ['nombre_lugar' => 'Armenia'],
            ['nombre_lugar' => 'Manizales'],
            ['nombre_lugar' => 'Bucaramanga'],
            ['nombre_lugar' => 'Cúcuta'],
            ['nombre_lugar' => 'Riohacha'],
            ['nombre_lugar' => 'Valledupar'],
            ['nombre_lugar' => 'Montería'],
            ['nombre_lugar' => 'Sincelejo'],
        ];

        foreach ($lugares as $lugar) {
            Lugar::create($lugar);
        }
    }
}

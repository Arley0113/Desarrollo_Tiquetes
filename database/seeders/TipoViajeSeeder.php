<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoViaje;

class TipoViajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposViaje = [
            ['nombre' => 'Solo Ida'],
            ['nombre' => 'Ida y Vuelta'],
        ];

        foreach ($tiposViaje as $tipo) {
            TipoViaje::create($tipo);
        }
    }
}

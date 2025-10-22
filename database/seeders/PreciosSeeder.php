<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Precio;
use App\Models\TipoViaje;

class PreciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoIda = TipoViaje::where('nombre', 'Solo Ida')->first();
        $tipoIdaVuelta = TipoViaje::where('nombre', 'Ida y Vuelta')->first();

        $precios = [
            // Precios económicos
            ['precio_ida' => 180000, 'precio_ida_vuelta' => 320000, 'id_viaje' => $tipoIda->id_viaje],
            ['precio_ida' => 220000, 'precio_ida_vuelta' => 380000, 'id_viaje' => $tipoIda->id_viaje],
            ['precio_ida' => 250000, 'precio_ida_vuelta' => 420000, 'id_viaje' => $tipoIda->id_viaje],
            
            // Precios medios
            ['precio_ida' => 280000, 'precio_ida_vuelta' => 480000, 'id_viaje' => $tipoIda->id_viaje],
            ['precio_ida' => 320000, 'precio_ida_vuelta' => 550000, 'id_viaje' => $tipoIda->id_viaje],
            ['precio_ida' => 350000, 'precio_ida_vuelta' => 620000, 'id_viaje' => $tipoIda->id_viaje],
            
            // Precios altos
            ['precio_ida' => 420000, 'precio_ida_vuelta' => 750000, 'id_viaje' => $tipoIda->id_viaje],
            ['precio_ida' => 480000, 'precio_ida_vuelta' => 850000, 'id_viaje' => $tipoIda->id_viaje],
            ['precio_ida' => 550000, 'precio_ida_vuelta' => 980000, 'id_viaje' => $tipoIda->id_viaje],
            
            // Precios premium
            ['precio_ida' => 650000, 'precio_ida_vuelta' => 1150000, 'id_viaje' => $tipoIda->id_viaje],
            ['precio_ida' => 750000, 'precio_ida_vuelta' => 1350000, 'id_viaje' => $tipoIda->id_viaje],
        ];

        foreach ($precios as $precio) {
            Precio::create($precio);
        }
    }
}

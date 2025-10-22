<?php

namespace App\Services;

use App\Models\Asiento;

class AsientoService
{
    public function obtenerDisponibles($avionId)
    {
        return Asiento::where('id_avion', $avionId)->get();
    }

    public function asignar($avionId)
    {
        return Asiento::where('id_avion', $avionId)->inRandomOrder()->first();
    }
}

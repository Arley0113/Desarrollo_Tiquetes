<?php

namespace App\Services;

use App\Models\Tiquete;
use App\Models\Asiento;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TiqueteService
{
    public function generarTiquetes($reserva)
    {
        return DB::transaction(function () use ($reserva) {
            // Asegurar que el vuelo esté cargado
            $reserva->loadMissing(['vuelo']);
            if (!$reserva->vuelo) {
                \Log::error('Reserva sin vuelo al generar tiquetes', [
                    'id_reserva' => $reserva->id_reserva ?? null,
                    'id_vuelo' => $reserva->id_vuelo ?? null,
                ]);
                throw new \Exception('La reserva no tiene vuelo asociado.');
            }

            foreach ($reserva->pasajeros as $pasajero) {
                $asiento = Asiento::where('id_avion', $reserva->vuelo->id_avion)
                    ->inRandomOrder()
                    ->first();

                Tiquete::create([
                    'codigo' => strtoupper(Str::random(10)),
                    'detalle_tiquete' => 'Vuelo ' . $reserva->vuelo->id_vuelo,
                    'id_reserva' => $reserva->id_reserva,
                    'id_vuelo' => $reserva->vuelo->id_vuelo,
                    'id_asiento' => $asiento->id_asiento,
                    'id_precio' => $reserva->vuelo->id_precio,
                ]);
            }
        });
    }
}

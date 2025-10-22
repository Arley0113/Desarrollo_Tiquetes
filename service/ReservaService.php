<?php

namespace App\Services;

use App\Models\Reserva;
use App\Models\Pasajero;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ReservaService
{
    public function crearReserva($usuarioId, $vueloId, $pasajeros)
    {
        return DB::transaction(function () use ($usuarioId, $vueloId, $pasajeros) {
            $reserva = Reserva::create([
                'numero_reserva' => strtoupper(Str::random(8)),
                'fecha_reserva' => now()->toDateString(),
                'hora_reserva' => now()->toTimeString(),
                'id_usuario' => $usuarioId,
            ]);

            foreach ($pasajeros as $p) {
                Pasajero::create([
                    'id_reserva' => $reserva->id_reserva,
                    'nombre_pasajero' => $p['nombre'],
                    'documento' => $p['documento'],
                    'es_acompanante' => $p['acompanante'] ?? false,
                ]);
            }

            return $reserva;
        });
    }
}

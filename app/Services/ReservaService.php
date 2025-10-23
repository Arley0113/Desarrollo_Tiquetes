<?php

namespace App\Services;

use App\Models\Reserva;
use App\Models\Pasajero;
use App\Models\Vuelo;
use App\Models\Asiento;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservaService
{
    /**
     * Crear una reserva completa con pasajeros y asientos
     */
    public function crearReservaCompleta($usuarioId, $vueloId, $pasajeros, $asientosIds)
    {
        return DB::transaction(function () use ($usuarioId, $vueloId, $pasajeros, $asientosIds) {
            // Verificar disponibilidad del vuelo
            $vuelo = Vuelo::findOrFail($vueloId);
            if ($vuelo->asientosDisponibles() < count($pasajeros)) {
                throw new \Exception('No hay suficientes asientos disponibles.');
            }

            // Verificar disponibilidad de asientos específicos
            $asientos = Asiento::whereIn('id_asiento', $asientosIds)
                ->where('estado', 'disponible')
                ->get();

            if ($asientos->count() !== count($asientosIds)) {
                throw new \Exception('Algunos asientos ya no están disponibles.');
            }

            // Crear reserva
            $reserva = Reserva::create([
                'numero_reserva' => 'RES-' . strtoupper(Str::random(8)),
                'fecha_reserva' => now()->toDateString(),
                'hora_reserva' => now()->toTimeString(),
                'id_usuario' => $usuarioId, // Puede ser null para usuarios no autenticados
            ]);

            // Crear pasajeros
            foreach ($pasajeros as $index => $pasajero) {
                Pasajero::create([
                    'id_reserva' => $reserva->id_reserva,
                    'nombre_pasajero' => $pasajero['nombre'],
                    'documento' => $pasajero['documento'] ?? 'TEMP-' . uniqid(),
                    'es_acompanante' => $pasajero['acompanante'] ?? false,
                    'id_asiento' => $asientosIds[$index] ?? null,
                ]);
            }

            // Marcar asientos como ocupados
            foreach ($asientosIds as $asientoId) {
                $asiento = Asiento::find($asientoId);
                if ($asiento) {
                    $asiento->ocupar();
                }
            }

            Log::info("Reserva creada exitosamente", [
                'reserva_id' => $reserva->id_reserva,
                'numero_reserva' => $reserva->numero_reserva,
                'usuario_id' => $usuarioId,
                'vuelo_id' => $vueloId
            ]);

            return $reserva;
        });
    }

    /**
     * Verificar disponibilidad de asientos para un vuelo
     */
    public function verificarDisponibilidadAsientos($vueloId, $asientosIds)
    {
        $vuelo = Vuelo::findOrFail($vueloId);
        
        // Verificar que el vuelo tiene asientos disponibles
        if ($vuelo->asientosDisponibles() < count($asientosIds)) {
            return false;
        }

        // Verificar que los asientos específicos están disponibles
        $asientosDisponibles = Asiento::whereIn('id_asiento', $asientosIds)
            ->where('estado', 'disponible')
            ->count();

        return $asientosDisponibles === count($asientosIds);
    }

    /**
     * Calcular precio total de la reserva
     */
    public function calcularPrecioTotal($vueloId, $asientosIds)
    {
        $vuelo = Vuelo::with('precio')->findOrFail($vueloId);
        $precioBase = $vuelo->precio->precio_ida ?? 0;

        $asientos = Asiento::whereIn('id_asiento', $asientosIds)->get();
        $precioExtras = $asientos->sum(function($asiento) {
            return $asiento->getPrecioAdicionalAttribute();
        });

        return $precioBase + $precioExtras;
    }

    /**
     * Cancelar reserva y liberar recursos
     */
    public function cancelarReserva($reservaId, $usuarioId)
    {
        return DB::transaction(function () use ($reservaId, $usuarioId) {
            $reserva = Reserva::where('id_usuario', $usuarioId)
                ->findOrFail($reservaId);

            // Liberar asientos
            foreach ($reserva->pasajeros as $pasajero) {
                if ($pasajero->id_asiento) {
                    $asiento = Asiento::find($pasajero->id_asiento);
                    if ($asiento) {
                        $asiento->liberar();
                    }
                }
            }

            // Eliminar tiquetes asociados
            $reserva->tiquetes()->delete();

            // Eliminar pasajeros
            $reserva->pasajeros()->delete();

            // Eliminar reserva
            $reserva->delete();

            Log::info("Reserva cancelada", [
                'reserva_id' => $reservaId,
                'usuario_id' => $usuarioId
            ]);

            return true;
        });
    }
}

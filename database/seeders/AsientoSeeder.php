<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asiento;
use App\Models\ModeloAvion;

class AsientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los aviones
        $aviones = ModeloAvion::all();

        if ($aviones->isEmpty()) {
            $this->command->warn('No hay aviones en la base de datos. Ejecuta ModeloAvionSeeder primero.');
            return;
        }

        foreach ($aviones as $avion) {
            $this->generarAsientosParaAvion($avion);
        }

        $this->command->info('Asientos generados correctamente para todos los aviones.');
    }

    /**
     * Generar asientos para un avión específico
     */
    private function generarAsientosParaAvion($avion)
    {
        // Eliminar asientos existentes para este avión
        Asiento::where('id_avion', $avion->id_avion)->delete();

        $columnas = ['A', 'B', 'C', 'D', 'E', 'F'];
        $filas = 20; // 20 filas de asientos

        // Filas 1 y 10 son de primera clase (extra)
        $filasExtra = [1, 10];
        
        // Filas 7 y 15 son salidas de emergencia
        $filasEmergencia = [7, 15];

        // Filas con algunos asientos no disponibles (pasillos, etc.)
        $asientosNoDisponibles = [
            3 => ['A', 'B'], // Fila 3: A y B no disponibles
            5 => ['C'],      // Fila 5: C no disponible
            7 => ['D', 'E'], // Fila 7: D y E no disponibles
            12 => ['A'],     // Fila 12: A no disponible
            15 => ['C'],     // Fila 15: C no disponible
            18 => ['A'],     // Fila 18: A no disponible
        ];

        $contador = 0;

        for ($fila = 1; $fila <= $filas; $fila++) {
            foreach ($columnas as $columna) {
                // Verificar si este asiento no debe existir
                if (isset($asientosNoDisponibles[$fila]) && in_array($columna, $asientosNoDisponibles[$fila])) {
                    continue; // Saltar este asiento
                }

                // Determinar tipo de asiento
                $tipoAsiento = 'normal';
                if (in_array($fila, $filasExtra)) {
                    $tipoAsiento = 'extra';
                } elseif (in_array($fila, $filasEmergencia)) {
                    $tipoAsiento = 'emergencia';
                }

                $contador++;

                // Crear asiento
                Asiento::create([
                    'numero_asiento' => $fila . $columna,
                    'fila' => $fila,
                    'columna' => $columna,
                    'tipo_asiento' => $tipoAsiento,
                    'estado' => 'disponible',
                    'id_avion' => $avion->id_avion,
                ]);
            }
        }

        $this->command->info("✓ {$contador} asientos generados para el avión: {$avion->nombre_avion} (ID: {$avion->id_avion})");
    }

    /**
     * Generar asientos para un avión específico (método público)
     * Útil para llamar desde otros lugares
     */
    public static function generarAsientos($idAvion)
    {
        $avion = ModeloAvion::findOrFail($idAvion);
        
        // Eliminar asientos existentes
        Asiento::where('id_avion', $idAvion)->delete();

        $columnas = ['A', 'B', 'C', 'D', 'E', 'F'];
        $filas = 20;
        $filasExtra = [1, 10];
        $filasEmergencia = [7, 15];
        
        $asientosNoDisponibles = [
            3 => ['A', 'B'],
            5 => ['C'],
            7 => ['D', 'E'],
            12 => ['A'],
            15 => ['C'],
            18 => ['A'],
        ];

        for ($fila = 1; $fila <= $filas; $fila++) {
            foreach ($columnas as $columna) {
                if (isset($asientosNoDisponibles[$fila]) && in_array($columna, $asientosNoDisponibles[$fila])) {
                    continue;
                }

                $tipoAsiento = 'normal';
                if (in_array($fila, $filasExtra)) {
                    $tipoAsiento = 'extra';
                } elseif (in_array($fila, $filasEmergencia)) {
                    $tipoAsiento = 'emergencia';
                }

                Asiento::create([
                    'numero_asiento' => $fila . $columna,
                    'fila' => $fila,
                    'columna' => $columna,
                    'tipo_asiento' => $tipoAsiento,
                    'estado' => 'disponible',
                    'id_avion' => $avion->id_avion,
                ]);
            }
        }
    }
}
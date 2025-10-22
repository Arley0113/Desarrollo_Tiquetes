<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles si no existen
        $roles = [
            [
                'id_rol' => 1,
                'nombre_rol' => 'Cliente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => 2,
                'nombre_rol' => 'Administrador',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($roles as $rol) {
            Rol::updateOrCreate(
                ['id_rol' => $rol['id_rol']],
                $rol
            );
        }
    }
}

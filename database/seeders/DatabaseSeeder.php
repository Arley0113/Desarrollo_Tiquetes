<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar seeders en orden de dependencias
        $this->call([
            RolSeeder::class,
            LugaresSeeder::class,
            TipoViajeSeeder::class,
            PreciosSeeder::class,
            AeropuertoSeeder::class,
            ModeloAvionSeeder::class,
            VuelosSeeder::class,
        ]);

        // Crear usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}

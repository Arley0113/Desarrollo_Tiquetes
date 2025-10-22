<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\VueloController;
use Illuminate\Http\Request;

class TestFullSearch extends Command
{
    protected $signature = 'test:full-search';
    protected $description = 'Test full flight search with controller';

    public function handle()
    {
        $this->info('=== TESTING FULL SEARCH ===');
        
        // Simular request
        $request = new Request();
        $request->merge([
            'origen' => '1', // Bogotá
            'destino' => '2', // Medellín
            'fecha' => now()->format('Y-m-d')
        ]);
        
        $this->info("Simulando búsqueda: Bogotá -> Medellín para " . now()->format('Y-m-d'));
        
        // Crear instancia del controlador
        $controller = new VueloController();
        
        try {
            // Ejecutar el método buscar
            $response = $controller->buscar($request);
            
            $this->info("Respuesta generada exitosamente");
            
            // Obtener los datos de la vista
            $data = $response->getData();
            
            if (isset($data['vuelos'])) {
                $this->info("Vuelos encontrados: " . $data['vuelos']->count());
                
                foreach ($data['vuelos']->take(3) as $vuelo) {
                    $this->line("Vuelo {$vuelo->id_vuelo}: {$vuelo->hora} - $" . number_format($vuelo->precio->precio_ida ?? 0));
                }
            } else {
                $this->error("No se encontraron datos de vuelos en la respuesta");
            }
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            $this->error("Trace: " . $e->getTraceAsString());
        }
    }
}
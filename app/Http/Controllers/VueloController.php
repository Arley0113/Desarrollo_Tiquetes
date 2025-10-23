<?php

namespace App\Http\Controllers;

use App\Models\Vuelo;
use App\Models\Lugar;
use Illuminate\Http\Request;

class VueloController extends Controller
{
    // Formulario de búsqueda de vuelos
    public function index()
    {
        $lugares = Lugar::all();
        return view('index', compact('lugares'));
    }

    // Procesa la búsqueda
    public function buscar(Request $request)
    {
    $request->validate([
        'origen' => 'required|different:destino',
        'destino' => 'required',
        'fecha' => 'required|date',
        'tipo_viaje' => 'required|in:ida,ida_regreso',
        'fecha_regreso' => 'nullable|required_if:tipo_viaje,ida_regreso|date|after:fecha'
    ]);

    // Buscar vuelos de ida para la fecha específica
    $vuelosIda = Vuelo::with(['origen', 'destino', 'avion', 'precio'])
        ->whereDate('fecha_vuelo', $request->fecha)
        ->where('id_origen', $request->origen)
        ->where('id_destino', $request->destino)
        ->get();

    // Si no hay vuelos para esa fecha específica, buscar vuelos para cualquier fecha entre origen y destino
    if ($vuelosIda->isEmpty()) {
        $vuelosIda = Vuelo::with(['origen', 'destino', 'avion', 'precio'])
            ->where('id_origen', $request->origen)
            ->where('id_destino', $request->destino)
            ->get();
    }

    $vuelosRegreso = collect();
    
    // Si es viaje de ida y regreso, buscar vuelos de regreso
    if ($request->tipo_viaje === 'ida_regreso') {
        $vuelosRegreso = Vuelo::with(['origen', 'destino', 'avion', 'precio'])
            ->whereDate('fecha_vuelo', $request->fecha_regreso)
            ->where('id_origen', $request->destino)
            ->where('id_destino', $request->origen)
            ->get();

        // Si no hay vuelos para esa fecha específica, buscar vuelos para cualquier fecha
        if ($vuelosRegreso->isEmpty()) {
            $vuelosRegreso = Vuelo::with(['origen', 'destino', 'avion', 'precio'])
                ->where('id_origen', $request->destino)
                ->where('id_destino', $request->origen)
                ->get();
        }
    }

    $origen = Lugar::find($request->origen);
    $destino = Lugar::find($request->destino);
    
    // Calcular precio máximo para el filtro (considerando ida y regreso)
    $precioMaximoIda = $vuelosIda->max(function($vuelo) {
        return $vuelo->precio ? $vuelo->precio->precio_ida : 0;
    }) ?: 1000000;
    
    $precioMaximoRegreso = $vuelosRegreso->max(function($vuelo) {
        return $vuelo->precio ? $vuelo->precio->precio_ida : 0;
    }) ?: 0;
    
    $precioMaximo = max($precioMaximoIda, $precioMaximoRegreso);

    return view('vuelos.detalle', compact('vuelosIda', 'vuelosRegreso', 'origen', 'destino', 'request', 'precioMaximo'));
}

// Muestra los detalles de un vuelo específico
public function mostrar($id)
{
    // Traer el vuelo con toda la información relacionada
    $vuelo = Vuelo::with(['origen', 'destino', 'avion', 'precio'])->findOrFail($id);

    $origen = $vuelo->origen;
    $destino = $vuelo->destino;

    return view('vuelos.detalle_unico', compact('vuelo', 'origen', 'destino'));
}


}

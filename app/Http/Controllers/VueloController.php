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
        'fecha' => 'required|date'
    ]);

    // Buscar vuelos para la fecha específica
    $vuelos = Vuelo::with(['origen', 'destino', 'avion', 'precio'])
        ->whereDate('fecha_vuelo', $request->fecha)
        ->where('id_origen', $request->origen)
        ->where('id_destino', $request->destino)
        ->get();

    // Si no hay vuelos para esa fecha específica, buscar vuelos para cualquier fecha entre origen y destino
    if ($vuelos->isEmpty()) {
        $vuelos = Vuelo::with(['origen', 'destino', 'avion', 'precio'])
            ->where('id_origen', $request->origen)
            ->where('id_destino', $request->destino)
            ->get();
    }

    $origen = Lugar::find($request->origen);
    $destino = Lugar::find($request->destino);
    
    // Calcular precio máximo para el filtro
    $precioMaximo = $vuelos->max(function($vuelo) {
        return $vuelo->precio ? $vuelo->precio->precio_ida : 0;
    }) ?: 1000000; // Valor por defecto si no hay vuelos

    return view('vuelos.detalle', compact('vuelos', 'origen', 'destino', 'request', 'precioMaximo'));
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

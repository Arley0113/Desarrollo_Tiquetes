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

        $vuelos = Vuelo::with(['origen', 'destino', 'avion', 'precio'])
            ->whereDate('fecha_vuelo', $request->fecha)
            ->where('id_origen', $request->origen)
            ->where('id_destino', $request->destino)
            ->get();

        return view('vuelos.resultados', compact('vuelos'));
    }
}

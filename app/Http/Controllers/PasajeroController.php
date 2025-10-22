<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasajeroController extends Controller

{
    // Mostrar el formulario
    public function create()
    {
        return view('vuelos.formulario'); 
    }

    // Guardar los datos del formulario
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|string',
        ]);

        // Aquí podrías guardar los datos en la base de datos
        
        return redirect()->route('pasajeros.create')->with('success', 'Datos guardados correctamente.');
    }
}



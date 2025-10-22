<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Listar usuarios
    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.create', compact('roles'));
    }

    // Guardar usuario nuevo
    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'primer_apellido' => 'required|string|max:50',
            'correo' => 'required|email|unique:usuarios,correo',
            'documento' => 'required|unique:usuarios,documento',
            'password' => 'required|min:6|confirmed',
            'id_rol' => 'required|exists:rol,id_rol',
        ]);

        Usuario::create([
            'nombres' => $request->nombres,
            'primer_apellido' => $request->primer_apellido,
            'correo' => $request->correo,
            'documento' => $request->documento,
            'id_rol' => $request->id_rol,
            'estado_usuario' => 'Activo',
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Rol::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    // Actualizar usuario
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombres' => 'required|string|max:100',
            'primer_apellido' => 'required|string|max:50',
            'correo' => 'required|email|unique:usuarios,correo,' . $usuario->id_usuario . ',id_usuario',
            'documento' => 'required|unique:usuarios,documento,' . $usuario->id_usuario . ',id_usuario',
            'id_rol' => 'required|exists:rol,id_rol',
        ]);

        $usuario->update([
            'nombres' => $request->nombres,
            'primer_apellido' => $request->primer_apellido,
            'correo' => $request->correo,
            'documento' => $request->documento,
            'id_rol' => $request->id_rol,
            'estado_usuario' => $request->estado_usuario ?? $usuario->estado_usuario,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar usuario
    public function destroy($id)
    {
        Usuario::destroy($id);
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}

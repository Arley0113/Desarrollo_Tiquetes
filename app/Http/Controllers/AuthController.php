<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /** 
     * Mostrar formulario de inicio de sesión 
     */
    public function loginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar inicio de sesión
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Inicio de sesión exitoso.');
        }

        return back()->withErrors(['correo' => 'Credenciales inválidas'])->onlyInput('correo');
    }

    /**
     * Mostrar formulario de registro
     */
    public function registerForm()
    {
        $roles = Rol::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Procesar registro de usuario
     */
    public function register(Request $request)
    {
        $request->validate([
            'nombres'           => 'required|string|max:100',
            'primer_apellido'   => 'required|string|max:50',
            'segundo_apellido'  => 'nullable|string|max:50',
            'fecha_nacimiento'  => 'required|date',
            'genero'            => 'required|string|max:20',
            'tipo_documento'    => 'required|string|max:10',
            'documento'         => 'required|string|max:30|unique:usuarios,documento',
            'celular'           => 'required|string|max:15',
            'correo'            => 'required|email|unique:usuarios,correo',
            'password'          => 'required|confirmed|min:6',
            'id_rol'            => 'required|exists:rol,id_rol',
        ]);

        $usuario = Usuario::create([
            'nombres'           => $request->nombres,
            'primer_apellido'   => $request->primer_apellido,
            'segundo_apellido'  => $request->segundo_apellido,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'genero'            => $request->genero,
            'tipo_documento'    => $request->tipo_documento,
            'documento'         => $request->documento,
            'celular'           => $request->celular,
            'correo'            => $request->correo,
            'id_rol'            => $request->id_rol,
            'estado_usuario'    => 'Activo',
            'password'          => Hash::make($request->password),
        ]);

        Auth::login($usuario);
        return redirect('/')->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Sesión cerrada.');
    }
}

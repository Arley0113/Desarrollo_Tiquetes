<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function loginForm()
    {
        return view('auth.login');
    }

    // Procesar login
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

    // Mostrar formulario de registro
    public function registerForm()
    {
        $roles = Rol::all();
        return view('auth.register', compact('roles'));
    }

    // Procesar registro
    public function register(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'primer_apellido' => 'required|string|max:50',
            'correo' => 'required|email|unique:usuarios,correo',
            'documento' => 'required|unique:usuarios,documento',
            'password' => 'required|confirmed|min:6',
            'id_rol' => 'required|exists:rol,id_rol',
        ]);

        $usuario = Usuario::create([
            'nombres' => $request->nombres,
            'primer_apellido' => $request->primer_apellido,
            'correo' => $request->correo,
            'documento' => $request->documento,
            'id_rol' => $request->id_rol,
            'estado_usuario' => 'Activo',
            'password' => Hash::make($request->password)
        ]);

        Auth::login($usuario);
        return redirect('/')->with('success', 'Usuario registrado correctamente.');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Sesión cerrada.');
    }
}

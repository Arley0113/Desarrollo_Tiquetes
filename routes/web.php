<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VueloController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\TiqueteController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| RUTAS WEB
|--------------------------------------------------------------------------
| Rutas principales del sistema de tiquetes aéreos.
| Incluye rutas públicas, autenticación, administración y módulos del usuario.
|--------------------------------------------------------------------------
*/

// =====================================================
// 🔹 PÁGINA PRINCIPAL (Pública)
// =====================================================
Route::get('/', [VueloController::class, 'index'])->name('inicio');
Route::get('/vuelos/buscar', [VueloController::class, 'buscar'])->name('vuelos.buscar');
Route::get('/vuelo/{id}', [VueloController::class, 'mostrar'])->name('vuelo.mostrar');


// =====================================================
// 🔹 AUTENTICACIÓN
// =====================================================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'loginForm')->name('login.form')->middleware('guest');
    Route::post('/login', 'login')->name('login');
    Route::get('/register', 'registerForm')->name('register.form')->middleware('guest');
    Route::post('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

// =====================================================
// 🔹 ADMINISTRADOR (solo admin)
// =====================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('admin.dashboard');
    Route::get('/vuelos', 'vuelos')->name('admin.vuelos');
    Route::get('/reportes', 'reportes')->name('admin.reportes');
});

// =====================================================
// 🔹 USUARIOS (solo admin)
// =====================================================
Route::middleware(['auth', 'role:admin'])->prefix('usuarios')->controller(UsuarioController::class)->group(function () {
    Route::get('/', 'index')->name('usuarios.index');
    Route::get('/crear', 'create')->name('usuarios.create');
    Route::post('/guardar', 'store')->name('usuarios.store');
    Route::get('/editar/{id}', 'edit')->name('usuarios.edit');
    Route::put('/actualizar/{id}', 'update')->name('usuarios.update');
    Route::delete('/eliminar/{id}', 'destroy')->name('usuarios.destroy');
});

// =====================================================
// 🔹 RESERVAS (usuarios autenticados)
// =====================================================
Route::middleware(['auth'])->prefix('reservas')->controller(ReservaController::class)->group(function () {
    Route::get('/', 'index')->name('reservas.index');
    Route::get('/crear/{vuelo}', 'create')->name('reservas.create');
    Route::post('/guardar', 'store')->name('reservas.store');
    Route::get('/ver/{id}', 'show')->name('reservas.show');
    Route::get('/editar/{id}', 'edit')->name('reservas.edit');
    Route::put('/actualizar/{id}', 'update')->name('reservas.update');
    Route::delete('/eliminar/{id}', 'destroy')->name('reservas.destroy');
});

// =====================================================
// 🔹 PAGOS (usuarios autenticados)
// =====================================================
Route::middleware(['auth'])->prefix('pagos')->controller(PagoController::class)->group(function () {
    Route::get('/', 'index')->name('pagos.index');
    Route::get('/crear/{reserva}', 'create')->name('pagos.create');
    Route::post('/guardar', 'store')->name('pagos.store');
    Route::get('/ver/{id}', 'show')->name('pagos.show');
    Route::delete('/eliminar/{id}', 'destroy')->name('pagos.destroy');
});

// =====================================================
// 🔹 TIQUETES (usuarios autenticados)
// =====================================================
Route::middleware(['auth'])->prefix('tiquetes')->controller(TiqueteController::class)->group(function () {
    Route::get('/', 'index')->name('tiquetes.index');
    Route::get('/generar/{reserva}', 'generar')->name('tiquetes.generar');
    Route::get('/ver/{id}', 'show')->name('tiquetes.show');
    Route::get('/descargar/{id}', 'descargar')->name('tiquetes.descargar');
});

// =====================================================
// 🔹 RUTA GENÉRICA DE ERROR O REDIRECCIÓN
// =====================================================
Route::fallback(function () {
    return redirect()->route('inicio');
});

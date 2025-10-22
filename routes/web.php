<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VueloController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\TiqueteController;

/*
|--------------------------------------------------------------------------
| RUTAS WEB
|--------------------------------------------------------------------------
| Aquí definimos todas las rutas principales del sistema de tiquetes.
| Separadas por módulos: Autenticación, Administración, Usuarios, etc.
|--------------------------------------------------------------------------
*/

Route::get('/', [AdminController::class, 'index'])->name('inicio');


// =====================================================
// AUTENTICACIÓN
// =====================================================
Route::controller(AuthController::class)->group(function () {
    // Formulario login y registro
    Route::get('/login', 'loginForm')->name('login.form');
    Route::post('/login', 'login')->name('login');
    Route::get('/register', 'registerForm')->name('register.form');
    Route::post('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('logout');
});


// =====================================================
// USUARIOS (solo para admin)
// =====================================================
Route::prefix('usuarios')->controller(UsuarioController::class)->group(function () {
    Route::get('/', 'index')->name('usuarios.index');
    Route::get('/crear', 'create')->name('usuarios.create');
    Route::post('/guardar', 'store')->name('usuarios.store');
    Route::get('/editar/{id}', 'edit')->name('usuarios.edit');
    Route::put('/actualizar/{id}', 'update')->name('usuarios.update');
    Route::delete('/eliminar/{id}', 'destroy')->name('usuarios.destroy');
});


// =====================================================
// ADMINISTRADOR (dashboard, reportes, gestión vuelos)
// =====================================================
Route::prefix('admin')->controller(AdminController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('admin.dashboard');
    Route::get('/vuelos', 'vuelos')->name('admin.vuelos');
    Route::get('/reportes', 'reportes')->name('admin.reportes');
});


// =====================================================
// VUELOS
// =====================================================
Route::prefix('vuelos')->controller(VueloController::class)->group(function () {
    Route::get('/', 'index')->name('vuelos.index');
    Route::get('/crear', 'create')->name('vuelos.create');
    Route::post('/guardar', 'store')->name('vuelos.store');
    Route::get('/editar/{id}', 'edit')->name('vuelos.edit');
    Route::put('/actualizar/{id}', 'update')->name('vuelos.update');
    Route::delete('/eliminar/{id}', 'destroy')->name('vuelos.destroy');
    Route::get('/buscar', 'buscar')->name('vuelos.buscar');
});


// =====================================================
// RESERVAS
// =====================================================
Route::prefix('reservas')->controller(ReservaController::class)->group(function () {
    Route::get('/', 'index')->name('reservas.index');
    Route::get('/crear', 'create')->name('reservas.create');
    Route::post('/guardar', 'store')->name('reservas.store');
    Route::get('/ver/{id}', 'show')->name('reservas.show');
    Route::get('/editar/{id}', 'edit')->name('reservas.edit');
    Route::put('/actualizar/{id}', 'update')->name('reservas.update');
    Route::delete('/eliminar/{id}', 'destroy')->name('reservas.destroy');
});


// =====================================================
// PAGOS
// =====================================================
Route::prefix('pagos')->controller(PagoController::class)->group(function () {
    Route::get('/', 'index')->name('pagos.index');
    Route::get('/crear', 'create')->name('pagos.create');
    Route::post('/guardar', 'store')->name('pagos.store');
    Route::get('/ver/{id}', 'show')->name('pagos.show');
    Route::delete('/eliminar/{id}', 'destroy')->name('pagos.destroy');
});


// =====================================================
// TIQUETES
// =====================================================
Route::prefix('tiquetes')->controller(TiqueteController::class)->group(function () {
    Route::get('/', 'index')->name('tiquetes.index');
    Route::get('/generar/{reserva}', 'generar')->name('tiquetes.generar');
    Route::get('/ver/{id}', 'show')->name('tiquetes.show');
    Route::get('/descargar/{id}', 'descargar')->name('tiquetes.descargar');
});

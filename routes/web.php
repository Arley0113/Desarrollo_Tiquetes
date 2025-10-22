<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\VueloController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\TiqueteController;
use App\Http\Controllers\PagoController;

// Ruta principal (puede apuntar al dashboard)
Route::get('/', function () {
    return view('welcome');
});

// === MÓDULO USUARIOS ===
Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/store', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/edit/{id}', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/update/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/delete/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});

// === MÓDULO ROLES ===
Route::prefix('roles')->group(function () {
    Route::get('/', [RolController::class, 'index'])->name('roles.index');
    Route::get('/create', [RolController::class, 'create'])->name('roles.create');
    Route::post('/store', [RolController::class, 'store'])->name('roles.store');
    Route::get('/edit/{id}', [RolController::class, 'edit'])->name('roles.edit');
    Route::put('/update/{id}', [RolController::class, 'update'])->name('roles.update');
    Route::delete('/delete/{id}', [RolController::class, 'destroy'])->name('roles.destroy');
});

// === MÓDULO VUELOS ===
Route::resource('vuelos', VueloController::class);

// === MÓDULO RESERVAS ===
Route::resource('reservas', ReservaController::class);

// === MÓDULO TIQUETES ===
Route::resource('tiquetes', TiqueteController::class);

// === MÓDULO PAGOS ===
Route::resource('pagos', PagoController::class);

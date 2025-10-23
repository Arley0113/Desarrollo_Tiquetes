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
use App\Http\Controllers\PasajeroController;

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
// 🔹 RESERVAS
// =====================================================
// Rutas públicas para el proceso de reserva
Route::prefix('reservas')->controller(ReservaController::class)->group(function () {
    // Ruta pública para iniciar reserva (sin autenticación)
    Route::get('/crear/{vuelo}', 'create')->name('reservas.create');
    
    // Paso 2: Guardar pasajeros y redirigir a selección de asientos
    Route::post('/pasajeros/guardar', 'guardarPasajeros')->name('reservas.pasajeros.guardar');
    
    // Paso 3: Mostrar mapa de selección de asientos
    Route::get('/asientos/{vuelo}', 'seleccionarAsientos')->name('reservas.asientos.seleccionar');
    
    // Paso 4: Guardar asientos seleccionados y crear reserva final
    Route::post('/asientos/{vuelo}', 'guardarAsientos')->name('reservas.asientos.guardar');
});

// Ruta temporal para test
Route::get('/test-asientos', function() {
    return view('reservas.test_asientos');
})->name('test.asientos');

// Ruta para test con datos reales
Route::get('/test-asientos-real', function() {
    $vuelo = App\Models\Vuelo::with(['origen', 'destino', 'precio', 'avion'])->first();
    $asientos = App\Models\Asiento::where('id_avion', $vuelo->id_avion)
        ->ordenados()
        ->get()
        ->groupBy('fila');
    $cantidadPasajeros = 1;
    $reservaTemp = null;
    
    return view('reservas.seleccionar_asientos_simple', compact(
        'vuelo',
        'asientos',
        'cantidadPasajeros',
        'reservaTemp'
    ));
})->name('test.asientos.real');

// Rutas que requieren autenticación
Route::middleware(['auth'])->prefix('reservas')->controller(ReservaController::class)->group(function () {
    Route::get('/', 'index')->name('reservas.index');
    Route::get('/ver/{id}', 'show')->name('reservas.show');
    Route::get('/confirmacion/{id}', 'confirmacion')->name('reservas.confirmacion');
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

// =====================================================


Route::get('/pasajeros', [PasajeroController::class, 'create'])->name('pasajeros.create');
Route::post('/pasajeros', [PasajeroController::class, 'store'])->name('pasajeros.guardar');
Route::get('/reserva/{id}', [ReservaController::class, 'mostrar'])->name('reserva.mostrar');

//////////////////////////////////////////////

//ticked de reserva por completar

Route::get('/reserva/{id}', function ($id) {

    $reserva = (object)[
        'codigo' => 'ABC123',
        'asiento' => '12A',
        'clase' => 'Económica',
        'total' => 150,
        'pasajero' => (object)[
            'nombre' => 'Juan Pérez'
        ],
        'vuelo' => (object)[
            'origen' => 'Bogotá',
            'destino' => 'Medellín',
            'hora_salida' => '08:00',
            'hora_llegada' => '09:15',
            'aerolinea' => 'Aerolínea XYZ'
        ]
    ];

    return view('reservas.mostrar', compact('reserva'));
});

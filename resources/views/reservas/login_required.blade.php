@extends('layouts.app')

@section('title', 'Iniciar Sesión Requerido')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Iniciar Sesión Requerido</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Información del Vuelo -->
                    <div class="alert alert-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="bi bi-airplane-fill"></i> Vuelo:</strong> {{ $vuelo->codigo_vuelo ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong><i class="bi bi-geo-alt-fill"></i> Ruta:</strong> 
                                {{ $vuelo->origen->nombre_lugar }} → {{ $vuelo->destino->nombre_lugar }}
                            </div>
                            <div class="col-md-6 mt-2">
                                <strong><i class="bi bi-calendar-fill"></i> Fecha:</strong> 
                                {{ date('d/m/Y', strtotime($vuelo->fecha_vuelo)) }}
                            </div>
                            <div class="col-md-6 mt-2">
                                <strong><i class="bi bi-clock-fill"></i> Hora:</strong> 
                                {{ date('H:i', strtotime($vuelo->hora)) }}
                            </div>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <i class="bi bi-person-lock display-1 text-warning"></i>
                        <h4 class="mt-3">Necesitas iniciar sesión para continuar</h4>
                        <p class="text-muted">Para realizar una reserva, debes tener una cuenta en nuestro sistema.</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-primary h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-plus display-4 text-primary mb-3"></i>
                                    <h5 class="card-title">¿Nuevo usuario?</h5>
                                    <p class="card-text">Crea una cuenta para comenzar a reservar vuelos.</p>
                                    <a href="{{ route('register.form') }}" class="btn btn-primary">
                                        <i class="bi bi-person-plus"></i> Registrarse
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-success h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-check display-4 text-success mb-3"></i>
                                    <h5 class="card-title">¿Ya tienes cuenta?</h5>
                                    <p class="card-text">Inicia sesión para continuar con tu reserva.</p>
                                    <a href="{{ route('login.form') }}" class="btn btn-success">
                                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light mt-4 border">
                        <i class="bi bi-info-circle text-primary"></i>
                        <strong>Nota:</strong> Una vez que inicies sesión, podrás continuar con el proceso de reserva desde donde lo dejaste.
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('vuelo.mostrar', $vuelo->id_vuelo) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Volver al Vuelo
                        </a>
                        <a href="{{ route('inicio') }}" class="btn btn-outline-primary">
                            <i class="bi bi-house"></i> Ir al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

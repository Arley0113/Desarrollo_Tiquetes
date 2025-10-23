@extends('layouts.app')

@section('title', 'Reserva Confirmada')

@section('content')
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header de confirmación -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success rounded-circle mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-check-lg text-white" style="font-size: 2.5rem;"></i>
                    </div>
                    <h1 class="text-white fw-bold mb-2">¡Reserva Confirmada!</h1>
                    <p class="text-white-50 h5">Tu aventura está a punto de comenzar</p>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex gap-3 justify-content-center mb-4">
                    <button class="btn btn-light btn-lg">
                        <i class="bi bi-download me-2"></i>Descargar Todos los Boletos
                    </button>
                    <button class="btn btn-outline-light btn-lg">
                        <i class="bi bi-share me-2"></i>Compartir
                    </button>
                </div>

                <!-- Confirmación enviada -->
                <div class="alert alert-info d-inline-block">
                    <i class="bi bi-envelope me-2"></i>
                    <strong>Confirmación Enviada</strong> - Se ha enviado un email con los detalles. También puedes ver tus boletos en la app móvil.
                </div>
            </div>
        </div>

        <!-- Boletos Electrónicos -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <h3 class="text-white mb-3">Boletos Electrónicos</h3>
                
                <!-- Pase de Abordar -->
                <div class="card shadow-lg border-0 mb-4">
                    <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-1">Pase de Abordar</h4>
                                <small>Boarding Pass</small>
                            </div>
                            <button class="btn btn-light btn-sm">Continuar</button>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- Código de reserva -->
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">{{ $reserva->numero_reserva }}</h2>
                        </div>

                        <!-- Detalles del vuelo -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small class="text-muted">Pasajero</small>
                                    <div class="fw-semibold">{{ $reserva->pasajeros->first()->nombre ?? 'N/A' }}</div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Fecha</small>
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($reserva->vuelo->fecha_salida)->format('d/m/Y') }}</div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Hora de Salida</small>
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($reserva->vuelo->hora_salida)->format('H:i') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small class="text-muted">Asiento</small>
                                    <div class="fw-semibold text-primary">{{ $reserva->tiquetes->first()->asiento->numero_completo ?? 'N/A' }}</div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Origen</small>
                                    <div class="fw-semibold">{{ $reserva->vuelo->origen->codigo ?? 'N/A' }} - {{ \Carbon\Carbon::parse($reserva->vuelo->hora_salida)->format('H:i') }}</div>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">Destino</small>
                                    <div class="fw-semibold">{{ $reserva->vuelo->destino->codigo ?? 'N/A' }} - {{ \Carbon\Carbon::parse($reserva->vuelo->hora_llegada)->format('H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Información adicional -->
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">Vuelo</small>
                                <div class="fw-semibold">{{ $reserva->vuelo->numero_vuelo ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Asiento</small>
                                <div class="fw-semibold text-primary">{{ $reserva->tiquetes->first()->asiento->numero_completo ?? 'N/A' }}</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Clase</small>
                                <div class="fw-semibold">Económica</div>
                            </div>
                        </div>

                        <!-- QR Code y acciones -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="qrCode">
                                    <label class="form-check-label" for="qrCode">
                                        Código QR de Embarque
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="d-flex gap-2 justify-content-end">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-download me-1"></i>Descargar
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-share me-1"></i>Compartir
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Información importante -->
                        <div class="alert alert-warning mt-4">
                            <h6 class="alert-heading">Información Importante</h6>
                            <ul class="mb-0 small">
                                <li>Presenta una identificación válida en el aeropuerto</li>
                                <li>Llega al aeropuerto 2 horas antes de la salida</li>
                                <li>Haz check-in 30 minutos antes de la salida</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Resumen del Viaje -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Resumen del Viaje</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">Código de Reserva</small>
                                <div class="fw-semibold">{{ $reserva->numero_reserva }}</div>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Total Pagado</small>
                                <div class="fw-semibold text-success h5">${{ number_format($reserva->pagos->sum('monto'), 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <small class="text-muted">Aerolínea</small>
                                <div class="fw-semibold">{{ $reserva->vuelo->aerolinea ?? 'Aerolínea XYZ' }}</div>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Pasajeros</small>
                                <div class="fw-semibold">{{ $reserva->pasajeros->count() }} pasajero{{ $reserva->pasajeros->count() > 1 ? 's' : '' }}</div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                Recordar viaje 2 horas antes
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ¿Qué sigue? -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h3 class="text-white mb-4">¿Qué sigue?</h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card h-100 border-0">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-envelope text-primary" style="font-size: 2rem;"></i>
                                </div>
                                <h6>Enviar a mi Email</h6>
                                <small class="text-muted">Confirmación, los detalles de la reserva</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-phone text-primary" style="font-size: 2rem;"></i>
                                </div>
                                <h6>Descargar la App</h6>
                                <small class="text-muted">Accede a tus boletos desde cualquier lugar</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-bag text-primary" style="font-size: 2rem;"></i>
                                </div>
                                <h6>Prepara tu Viaje</h6>
                                <small class="text-muted">Revisa importantes de viaje y documentación</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón volver al inicio -->
                <div class="text-center mt-4">
                    <a href="{{ route('inicio') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-house me-2"></i>Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 15px;
    }
    
    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }
    
    .btn {
        border-radius: 10px;
    }
    
    .alert {
        border-radius: 10px;
    }
</style>
@endpush

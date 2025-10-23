@extends('layouts.app')

@section('title', 'Mis Reservas')

@section('content')
<div class="container-fluid py-4">
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">
                            <i class="bi bi-ticket-perforated me-2 text-primary"></i>
                            Mis Reservas
                        </h2>
                        <p class="text-muted mb-0">Gestiona todas tus reservas de vuelos</p>
                    </div>
                    <a href="{{ route('inicio') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Nueva Reserva
                    </a>
                </div>
            </div>
        </div>

        @if($reservas->count() > 0)
            <div class="row">
                @foreach($reservas as $reserva)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Reserva #{{ $reserva->numero_reserva }}</h6>
                                    <small>{{ \Carbon\Carbon::parse($reserva->fecha_reserva)->format('d/m/Y H:i') }}</small>
                                </div>
                                <span class="badge bg-light text-dark">
                                    {{ $reserva->tiquetes->count() }} tiquete{{ $reserva->tiquetes->count() > 1 ? 's' : '' }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Información del vuelo -->
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-airplane text-primary me-2"></i>
                                    <strong>{{ $reserva->tiquetes->first()->vuelo->origen->nombre ?? 'N/A' }}</strong>
                                    <i class="bi bi-arrow-right mx-2 text-muted"></i>
                                    <strong>{{ $reserva->tiquetes->first()->vuelo->destino->nombre ?? 'N/A' }}</strong>
                                </div>
                                <div class="row text-muted small">
                                    <div class="col-6">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($reserva->tiquetes->first()->vuelo->fecha_salida ?? now())->format('d/m/Y') }}
                                    </div>
                                    <div class="col-6">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($reserva->tiquetes->first()->vuelo->hora_salida ?? now())->format('H:i') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Pasajeros -->
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Pasajeros:</h6>
                                @foreach($reserva->pasajeros as $pasajero)
                                <div class="d-flex align-items-center mb-1">
                                    <i class="bi bi-person-circle text-primary me-2"></i>
                                    <span>{{ $pasajero->nombre }}</span>
                                </div>
                                @endforeach
                            </div>

                            <!-- Asientos -->
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Asientos:</h6>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($reserva->tiquetes as $tiquete)
                                    <span class="badge bg-primary">{{ $tiquete->asiento->numero_completo ?? 'N/A' }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Estado y precio -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-success">Confirmada</span>
                                </div>
                                <div class="text-end">
                                    <div class="h6 text-primary mb-0">
                                        ${{ number_format($reserva->pagos->sum('monto'), 0, ',', '.') }}
                                    </div>
                                    <small class="text-muted">Total pagado</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('reservas.confirmacion', $reserva->id_reserva) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                    <i class="bi bi-eye me-1"></i>Ver Detalles
                                </a>
                                <a href="{{ route('tiquetes.generar', $reserva->id_reserva) }}" class="btn btn-primary btn-sm flex-fill">
                                    <i class="bi bi-download me-1"></i>Descargar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="row">
                <div class="col-12">
                    {{ $reservas->links() }}
                </div>
            </div>
        @else
            <!-- Estado vacío -->
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-5">
                            <div class="mb-4">
                                <i class="bi bi-ticket-perforated text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-muted mb-3">No tienes reservas aún</h4>
                            <p class="text-muted mb-4">
                                Comienza a explorar nuestros vuelos y reserva tu próximo viaje.
                            </p>
                            <a href="{{ route('inicio') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-search me-2"></i>Buscar Vuelos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    
    .badge {
        border-radius: 8px;
    }
    
    .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

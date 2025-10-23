@extends('layouts.app')

@section('title', 'Mis Tiquetes')

@section('content')
<div class="container-fluid py-4">
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">
                            <i class="bi bi-receipt me-2 text-primary"></i>
                            Mis Tiquetes
                        </h2>
                        <p class="text-muted mb-0">Descarga y gestiona tus tiquetes de vuelo</p>
                    </div>
                    <a href="{{ route('inicio') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Nueva Reserva
                    </a>
                </div>
            </div>
        </div>

        @if(isset($tiquetes) && $tiquetes->count() > 0)
            <div class="row">
                @foreach($tiquetes as $tiquete)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Tiquete #{{ $tiquete->id_tiquete ?? 'N/A' }}</h6>
                                    <small>{{ \Carbon\Carbon::parse($tiquete->created_at)->format('d/m/Y H:i') }}</small>
                                </div>
                                <span class="badge bg-light text-dark">
                                    {{ $tiquete->asiento->numero_completo ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Información del vuelo -->
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-airplane text-primary me-2"></i>
                                    <strong>{{ $tiquete->vuelo->origen->nombre ?? 'N/A' }}</strong>
                                    <i class="bi bi-arrow-right mx-2 text-muted"></i>
                                    <strong>{{ $tiquete->vuelo->destino->nombre ?? 'N/A' }}</strong>
                                </div>
                                <div class="row text-muted small">
                                    <div class="col-6">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($tiquete->vuelo->fecha_salida)->format('d/m/Y') }}
                                    </div>
                                    <div class="col-6">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($tiquete->vuelo->hora_salida)->format('H:i') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Información del pasajero -->
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Pasajero:</h6>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle text-primary me-2"></i>
                                    <span>{{ $tiquete->pasajero->nombre ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Información del asiento -->
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">Asiento:</h6>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                    <span class="badge bg-primary fs-6">{{ $tiquete->asiento->numero_completo ?? 'N/A' }}</span>
                                    @if($tiquete->asiento->tipo_asiento === 'extra')
                                        <span class="badge bg-warning ms-2">Extra</span>
                                    @elseif($tiquete->asiento->tipo_asiento === 'emergencia')
                                        <span class="badge bg-success ms-2">Emergencia</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-success">Válido</span>
                                </div>
                                <div class="text-end">
                                    <div class="h6 text-primary mb-0">
                                        ${{ number_format($tiquete->precio_total ?? 0, 0, ',', '.') }}
                                    </div>
                                    <small class="text-muted">Precio</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light border-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('tiquetes.show', $tiquete->id_tiquete) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                    <i class="bi bi-eye me-1"></i>Ver
                                </a>
                                <a href="{{ route('tiquetes.descargar', $tiquete->id_tiquete) }}" class="btn btn-primary btn-sm flex-fill">
                                    <i class="bi bi-download me-1"></i>Descargar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginación -->
            @if(method_exists($tiquetes, 'links'))
            <div class="row">
                <div class="col-12">
                    {{ $tiquetes->links() }}
                </div>
            </div>
            @endif
        @else
            <!-- Estado vacío -->
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-5">
                            <div class="mb-4">
                                <i class="bi bi-receipt text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="text-muted mb-3">No tienes tiquetes aún</h4>
                            <p class="text-muted mb-4">
                                Realiza una reserva para obtener tus tiquetes de vuelo.
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

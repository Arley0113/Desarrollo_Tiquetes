@extends('layouts.app')

@section('title', 'Detalles del vuelo ' . $vuelo->codigo_vuelo)

@section('content')
<div class="container my-5">
    <h4 class="fw-bold">{{ $origen->nombre_lugar }} → {{ $destino->nombre_lugar }}</h4>
    <div class="card shadow-sm p-4 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold">{{ $vuelo->avion->nombre ?? 'Aerolínea' }}</h5>
                <small class="text-muted">{{ $vuelo->codigo_vuelo }}</small>
            </div>
            <div class="text-center">
                <h6 class="fw-bold">{{ date('H:i', strtotime($vuelo->hora_salida)) }}</h6>
                <small>{{ $origen->nombre_lugar }}</small>
            </div>
            <div class="text-center">
                <small>{{ $vuelo->duracion }}</small>
            </div>
            <div class="text-center">
                <h6 class="fw-bold">{{ date('H:i', strtotime($vuelo->hora_llegada)) }}</h6>
                <small>{{ $destino->nombre_lugar }}</small>
            </div>
            <div class="text-end">
                <h5 class="fw-bold text-primary">${{ number_format($vuelo->precio->valor ?? 0, 0, ',', '.') }}</h5>
            </div>
        </div>
        <p><strong>Comodidades:</strong> 
            {{ $vuelo->wifi ? 'WiFi' : '' }}
            {{ $vuelo->reembolsable ? ' | Reembolsable' : '' }}
            {{ $vuelo->directo ? ' | Directo' : '' }}
        </p>
        <a href="{{ route('reservas.create', $vuelo->id_vuelo) }}" class="btn btn-primary mt-3">Reservar este vuelo</a>
    </div>
</div>
@endsection

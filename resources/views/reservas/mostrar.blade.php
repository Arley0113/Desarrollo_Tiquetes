@extends('layouts.app')

@section('title', 'Reserva Confirmada')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-success">¡Reserva Confirmada! 🎉</h1>
        <p class="text-muted">Tu aventura está a punto de comenzar</p>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="text-primary">Boletos Electrónicos</h5>
            <div class="card mt-3 p-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                <h6>Pase de Abordar</h6>
                <p><strong>Código de Reserva:</strong> {{ $reserva->codigo }}</p>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Pasajero:</strong> {{ $reserva->pasajero->nombre }}</p>
                        <p><strong>Asiento:</strong> {{ $reserva->asiento }}</p>
                        <p><strong>Clase:</strong> {{ $reserva->clase }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p><strong>Origen:</strong> {{ $reserva->vuelo->origen }}</p>
                        <p><strong>Destino:</strong> {{ $reserva->vuelo->destino }}</p>
                        <p><strong>Hora de Salida:</strong> {{ $reserva->vuelo->hora_salida }}</p>
                        <p><strong>Hora de Llegada:</strong> {{ $reserva->vuelo->hora_llegada }}</p>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-light">Descargar QR</button>
                    <button class="btn btn-light">Imprimir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm p-4 mb-4">
        <h5>Resumen del viaje</h5>
        <p><strong>Total Pagado:</strong> ${{ $reserva->total }}</p>
        <p><strong>Aerolínea:</strong> {{ $reserva->vuelo->aerolinea }}</p>
        <p><strong>Pasajeros:</strong> 1</p>
    </div>

    <div class="text-center mt-5">
        <h5>¿Qué sigue?</h5>
        <div class="d-flex justify-content-center gap-3">
            <button class="btn btn-primary">Enviar por Email</button>
            <button class="btn btn-secondary">Descargar App</button>
            <button class="btn btn-success">Preparar tu viaje</button>
        </div>
    </div>
</div>
@endsection
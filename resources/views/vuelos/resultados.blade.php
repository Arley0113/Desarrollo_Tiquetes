@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Resultados de búsqueda</h2>

    @if($vuelos->isEmpty())
        <div class="alert alert-warning text-center">No se encontraron vuelos para tu búsqueda.</div>
    @else
        <div class="row g-4">
            @foreach($vuelos as $vuelo)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">
                                {{ $vuelo->origen->nombre }} → {{ $vuelo->destino->nombre }}
                            </h5>
                            <p class="text-muted mb-1">Fecha: {{ $vuelo->fecha_vuelo }}</p>
                            <p class="text-primary fw-bold">Desde ${{ number_format($vuelo->precio->valor, 0, ',', '.') }} COP</p>
                            <a href="#" class="btn btn-outline-primary w-100">Reservar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

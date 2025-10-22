@extends('layouts.app')

@section('title', 'Inicio | VuelosYa')

@section('content')
<header class="header-busqueda d-flex align-items-center justify-content-center text-center text-white">
    <div class="overlay-box p-5 rounded shadow-lg">
        <h1 class="fw-bold mb-4">Encuentra tu vuelo ideal</h1>

        <form method="GET" action="{{ route('vuelos.buscar') }}" 
              class="row g-2 justify-content-center buscador-form bg-white p-3 rounded shadow">
            <div class="col-12 col-md-3">
                <select name="origen" class="form-select" required>
                    <option value="">Origen</option>
                    @foreach ($lugares as $lugar)
                        <option value="{{ $lugar->id }}">{{ $lugar->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-3">
                <select name="destino" class="form-select" required>
                    <option value="">Destino</option>
                    @foreach ($lugares as $lugar)
                        <option value="{{ $lugar->id }}">{{ $lugar->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-3">
                <input type="date" name="fecha" class="form-control" required>
            </div>

            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </form>
    </div>
</header>

<main class="container my-5">
    <h2 class="text-center mb-4 fw-bold text-primary fade-in">Destinos populares</h2>
    <div class="row g-4">
        @php
            $destinos = [
                ['nombre' => 'Pereira', 'precio' => '280.000', 'img' => 'https://media.istockphoto.com/id/611891416/photo/santa-rosa-de-cabal-hot-springs.jpg?s=2048x2048'],
                ['nombre' => 'Bogotá', 'precio' => '180.000', 'img' => 'https://media.istockphoto.com/id/1453256961/photo/aerial-view-of-modern-bogota-cityscape-in-colombia-in-the-afternoon.jpg?s=2048x2048'],
                ['nombre' => 'Armenia', 'precio' => '420.000', 'img' => 'https://media.istockphoto.com/id/856585242/photo/view-over-the-city-of-yerevan-capital-of-armenia-with-the-two-peaks-of-the-mount-ararat-in-the.jpg?s=2048x2048'],
                ['nombre' => 'Santa Marta', 'precio' => '395.000', 'img' => 'https://cdn.pixabay.com/photo/2015/12/01/20/28/road-1072828_1280.jpg'],
                ['nombre' => 'Riohacha', 'precio' => '280.000', 'img' => 'https://cdn.pixabay.com/photo/2022/11/02/16/47/saline-7565442_1280.jpg'],
                ['nombre' => 'Cartagena', 'precio' => '350.000', 'img' => 'https://cdn.pixabay.com/photo/2020/01/23/19/09/cartagena-de-indias-4788526_1280.jpg'],
            ];
        @endphp

        @foreach ($destinos as $index => $destino)
            <div class="col-12 col-sm-6 col-md-4 fade-in" style="animation-delay: {{ $index * 0.2 }}s;">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $destino['img'] }}" class="card-img-top" alt="{{ $destino['nombre'] }}">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">{{ $destino['nombre'] }}</h5>
                        <p class="text-muted">Vuelos desde ${{ $destino['precio'] }} COP</p>
                        <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</main>

<section class="py-5 text-center text-white fade-in-bottom" 
         style="background: linear-gradient(90deg,#155DFC 0%, #9810FA 50%, #E60076 100%);">
    <div class="container">
        <h2 class="fw-bold">¿Listo para tu próxima aventura?</h2>
        <p class="mb-4">Únete a millones de viajeros que confían en nosotros</p>
        <a href="{{ route('register.form') }}" class="btn btn-light btn-lg">Comenzar ahora</a>
    </div>
</section>

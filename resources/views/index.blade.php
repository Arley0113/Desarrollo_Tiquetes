@extends('layouts.app')

@section('title', 'Inicio | VuelosYa')

@section('content')
<header class="header-busqueda d-flex align-items-center justify-content-center text-center text-white">
    <div class="overlay-box p-5 rounded shadow-lg">
        <h1 class="fw-bold mb-4">Encuentra tu vuelo ideal</h1>

        <form method="GET" action="{{ route('vuelos.buscar') }}" id="form-busqueda"
              class="row g-2 justify-content-center buscador-form bg-white p-3 rounded shadow">
            
            {{-- CAMPO ORIGEN --}}
            <div class="col-12 col-md-3">
                <select name="origen" class="form-control" required>
                    <option value="">Selecciona origen</option>
                    @foreach($lugares as $lugar)
                        {{-- Usamos array syntax para compatibilidad --}}
                        <option value="{{ is_array($lugar) ? $lugar['id_lugar'] : $lugar->id_lugar }}">
                            {{ is_array($lugar) ? $lugar['nombre_lugar'] : $lugar->nombre_lugar }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- CAMPO DESTINO --}}
            <div class="col-12 col-md-3">
                <select name="destino" class="form-control" required>
                    <option value="">Selecciona destino</option>
                    @foreach($lugares as $lugar)
                        <option value="{{ is_array($lugar) ? $lugar['id_lugar'] : $lugar->id_lugar }}">
                            {{ is_array($lugar) ? $lugar['nombre_lugar'] : $lugar->nombre_lugar }}
                        </option>
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
@endsection

@push('styles')
<style>
body { font-family: 'Poppins', sans-serif; background-color: #131415; }
.header-busqueda { background: url('{{ asset('images/fondo-aerolinea.jpg') }}') no-repeat center center; background-size: cover; height: 90vh; position: relative; }
.overlay-box { background: rgba(0,0,0,0.65); border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(8px); max-width: 900px; color: #fff; animation: fadeInBox 1.2s ease forwards; }
@keyframes fadeInBox { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
.fade-in { opacity: 0; transform: translateY(30px); animation: fadeInUp 1s forwards; }
.fade-in-bottom { opacity: 0; transform: translateY(60px); animation: fadeInUp 1.5s forwards; }
@keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
.card { border: none; transition: transform 0.3s ease, box-shadow 0.3s ease; }
.card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.2); }
.card-img-top { height: 200px; object-fit: cover; }
.btn-primary { background-color: #0d6efd; border: none; transition: background-color 0.3s ease; }
.btn-primary:hover { background-color: #0b5ed7; }
</style>
@endpush

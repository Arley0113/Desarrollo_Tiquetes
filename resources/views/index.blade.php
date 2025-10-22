@extends('layouts.app')

@section('title', 'Inicio | VuelosYa')

@section('content')
<header class="header-busqueda text-center text-white d-flex align-items-center justify-content-center">
    <div class="container">
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
    <h2 class="text-center mb-4 fw-bold text-primary">Destinos populares</h2>
    <div class="row g-4">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="https://media.istockphoto.com/id/611891416/photo/santa-rosa-de-cabal-hot-springs.jpg?s=2048x2048&w=is&k=20&c=o7C8DmZFSRMnnvW548gskWH5kL8eIyDV78PLbFTvLBo=" class="card-img-top" alt="Pereira">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Pereira</h5>
                    <p class="text-muted">Vuelos desde $280.000 COP</p>
                    <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="https://media.istockphoto.com/id/1453256961/photo/aerial-view-of-modern-bogota-cityscape-in-colombia-in-the-afternoon.jpg?s=2048x2048&w=is&k=20&c=aVh3UzSwTyOBOqx3jNR25439oH-nKGiXKObnaTm7dyk=" class="card-img-top" alt="Bogotá">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Bogotá</h5>
                    <p class="text-muted">Vuelos desde $180.000 COP</p>
                    <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="https://media.istockphoto.com/id/856585242/photo/view-over-the-city-of-yerevan-capital-of-armenia-with-the-two-peaks-of-the-mount-ararat-in-the.jpg?s=2048x2048&w=is&k=20&c=x8GmlmAEy1ArtOdIM3gcq3fJ9QX32UN94scFmMvtgII=" class="card-img-top" alt="Armenia">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Armenia</h5>
                    <p class="text-muted">Vuelos desde $420.000 COP</p>
                    <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="https://cdn.pixabay.com/photo/2015/12/01/20/28/road-1072828_1280.jpg" class="card-img-top" alt="Santa Marta">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Santa Marta</h5>
                    <p class="text-muted">Vuelos desde $395.000 COP</p>
                    <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="https://cdn.pixabay.com/photo/2022/11/02/16/47/saline-7565442_1280.jpg" class="card-img-top" alt="Riohacha">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Riohacha</h5>
                    <p class="text-muted">Vuelos desde $280.000 COP</p>
                    <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="https://cdn.pixabay.com/photo/2020/01/23/19/09/cartagena-de-indias-4788526_1280.jpg" class="card-img-top" alt="Cartagena">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">Cartagena</h5>
                    <p class="text-muted">Vuelos desde $350.000 COP</p>
                    <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                </div>
            </div>
        </div>
    </div>
</main>

<section class="py-5 text-center text-white" style="background: linear-gradient(90deg,#155DFC 0%, #9810FA 50%, #E60076 100%);">
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

@extends('layouts.app')

@section('title', 'Información de Pasajeros')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-3">Información de Pasajeros</h2>
            <p class="text-muted">Completa la información de todos los pasajeros</p>

            <form action="{{ route('pasajeros.guardar') }}" method="POST">
                @csrf
                <h5 class="mt-4">Pasajero 1 (Principal)</h5>
                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre"
                            value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="apellido" class="form-label">Apellido *</label>
                        <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellido"
                            value="{{ old('apellido') }}" required>
                        @error('apellido')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="tu@email.com"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono *</label>
                        <input type="tel" name="telefono" id="telefono" class="form-control" placeholder="+57 300 000 0000"
                            value="{{ old('telefono') }}" required>
                        @error('telefono')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control"
                            value="{{ old('fecha_nacimiento') }}" required>
                        @error('fecha_nacimiento')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="genero" class="form-label">Género *</label>
                        <select name="genero" id="genero" class="form-select" required>
                            <option value="">Selecciona...</option>
                            <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('genero')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        Continuar a Selección de Asientos →
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

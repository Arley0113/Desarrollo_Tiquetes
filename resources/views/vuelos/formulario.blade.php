@extends('layouts.app')

@section('title', 'Información de Pasajeros')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h2 class="mb-0">Información de Pasajeros</h2>
            <p class="small mb-0">Completa la información de todos los pasajeros y datos de contacto</p>
        </div>

        <div class="card-body p-5">
            @if(session('success'))
                <div class="alert alert-success rounded-3">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('pasajeros.guardar') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <h5 class="mb-3 fw-bold">Pasajero 1 (Principal)</h5>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold">Nombres *</label>
                            <input type="text" name="nombre" id="nombre" class="form-control form-control-lg" placeholder="Nombres" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="apellido" class="form-label fw-semibold">Apellidos *</label>
                            <input type="text" name="apellido" id="apellido" class="form-control form-control-lg" placeholder="Apellidos" value="{{ old('apellido') }}" required>
                            @error('apellido')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tipo_documento" class="form-label fw-semibold">Tipo de Documento *</label>
                            <select name="tipo_documento" id="tipo_documento" class="form-select form-select-lg" required>
                                <option value="">Selecciona...</option>
                                <option value="cc">Cédula de Ciudadanía</option>
                                <option value="ti">Tarjeta de Identidad</option>
                                <option value="pasaporte">Pasaporte</option>
                                <option value="ce">Cédula de Extranjería</option>
                            </select>
                            @error('tipo_documento')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="numero_documento" class="form-label fw-semibold">Número de Documento *</label>
                            <input type="text" name="numero_documento" id="numero_documento" class="form-control form-control-lg" placeholder="Número de documento" value="{{ old('numero_documento') }}" required>
                            @error('numero_documento')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label fw-semibold">Fecha de Nacimiento *</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control form-control-lg" value="{{ old('fecha_nacimiento') }}" required>
                            @error('fecha_nacimiento')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="genero" class="form-label fw-semibold">Género *</label>
                            <select name="genero" id="genero" class="form-select form-select-lg" required>
                                <option value="">Selecciona...</option>
                                <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email *</label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="tu@email.com" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="telefono" class="form-label fw-semibold">Teléfono *</label>
                            <input type="tel" name="telefono" id="telefono" class="form-control form-control-lg" placeholder="+57 300 000 0000" value="{{ old('telefono') }}" required>
                            @error('telefono')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Condición del infante si menor de 3 años -->
                        <div class="col-md-12 mt-3">

                            <label for="condicion_infante" class="form-label fw-semibold">Condición del infante (si menor de 3 años) | Solo Aplica si tienes un infante</label>
                            <input type="text" name="condicion_infante" id="condicion_infante" class="form-control form-control-lg" placeholder="Condición especial del infante">
                        </div>

                    </div>
                </div>

                <!-- Datos de contacto de emergencia -->
                <div class="mb-4 mt-5">
                    <h5 class="mb-3 fw-bold">Contacto de Emergencia</h5>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="em_nombre" class="form-label fw-semibold">Nombre del contacto *</label>
                            <input type="text" name="em_nombre" id="em_nombre" class="form-control form-control-lg" placeholder="Nombre completo" required>
                            @error('em_nombre')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="em_telefono" class="form-label fw-semibold">Teléfono *</label>
                            <input type="tel" name="em_telefono" id="em_telefono" class="form-control form-control-lg" placeholder="+57 300 000 0000" required>
                            @error('em_telefono')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="em_relacion" class="form-label fw-semibold">Relación *</label>
                            <input type="text" name="em_relacion" id="em_relacion" class="form-control form-control-lg" placeholder="Ej: Madre, Padre, Amigo" required>
                            @error('em_relacion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="mt-5 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                        Continuar con el pago →
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

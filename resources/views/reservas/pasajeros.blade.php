@extends('layouts.app')

@section('title', 'Información de Pasajeros')

@section('content')
<div class="container-fluid py-4">
    <div class="container">
        <!-- Header del vuelo -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-2">
                                    <i class="bi bi-airplane me-2 text-primary"></i>
                                    {{ $vuelo->origen->nombre_lugar }} → {{ $vuelo->destino->nombre_lugar }}
                                </h4>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($vuelo->fecha_vuelo)->format('d/m/Y') }} 
                                    <i class="bi bi-clock me-1 ms-3"></i>
                                    {{ \Carbon\Carbon::parse($vuelo->hora)->format('H:i') }}
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="h5 text-primary mb-0">${{ number_format($vuelo->precio->precio_ida, 0, ',', '.') }}</div>
                                <small class="text-muted">Precio base</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="bi bi-person-lines-fill me-2"></i>
                            Información del Pasajero
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('reservas.pasajeros.guardar') }}" id="pasajerosForm">
                            @csrf
                            <input type="hidden" name="id_vuelo" value="{{ $vuelo->id_vuelo }}">
                            
                            <div class="row g-3">
                                <!-- Nombres -->
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label fw-semibold">
                                        <i class="bi bi-person me-2"></i>Nombres *
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nombre') is-invalid @enderror" 
                                           id="nombre" 
                                           name="nombre" 
                                           placeholder="Tu nombre"
                                           value="{{ old('nombre') }}" 
                                           required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Apellidos -->
                                <div class="col-md-6">
                                    <label for="apellido" class="form-label fw-semibold">
                                        <i class="bi bi-person me-2"></i>Apellidos *
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('apellido') is-invalid @enderror" 
                                           id="apellido" 
                                           name="apellido" 
                                           placeholder="Tus apellidos"
                                           value="{{ old('apellido') }}" 
                                           required>
                                    @error('apellido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-2"></i>Correo Electrónico *
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           placeholder="tu@email.com"
                                           value="{{ old('email') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Teléfono -->
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-semibold">
                                        <i class="bi bi-phone me-2"></i>Teléfono *
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('telefono') is-invalid @enderror" 
                                           id="telefono" 
                                           name="telefono" 
                                           placeholder="+57 300 123 4567"
                                           value="{{ old('telefono') }}" 
                                           required>
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="col-md-6">
                                    <label for="fecha_nacimiento" class="form-label fw-semibold">
                                        <i class="bi bi-calendar me-2"></i>Fecha de Nacimiento *
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                           id="fecha_nacimiento" 
                                           name="fecha_nacimiento" 
                                           value="{{ old('fecha_nacimiento') }}" 
                                           required>
                                    @error('fecha_nacimiento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Género -->
                                <div class="col-md-6">
                                    <label for="genero" class="form-label fw-semibold">
                                        <i class="bi bi-gender-ambiguous me-2"></i>Género *
                                    </label>
                                    <select class="form-select @error('genero') is-invalid @enderror" 
                                            id="genero" 
                                            name="genero" 
                                            required>
                                        <option value="">Selecciona tu género</option>
                                        <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('genero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Información importante -->
                            <div class="alert alert-info mt-4">
                                <h6 class="alert-heading">
                                    <i class="bi bi-info-circle me-2"></i>Información Importante
                                </h6>
                                <ul class="mb-0 small">
                                    <li>Los datos deben coincidir exactamente con tu documento de identidad</li>
                                    <li>El correo electrónico se utilizará para enviar la confirmación de tu reserva</li>
                                    <li>El teléfono será usado para notificaciones importantes sobre tu vuelo</li>
                                </ul>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('vuelo.mostrar', $vuelo->id_vuelo) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Volver
                                </a>
                                <button type="submit" class="btn btn-primary" id="btnContinuar">
                                    <i class="bi bi-arrow-right me-2"></i>Continuar a Asientos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn {
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .alert {
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pasajerosForm');
    const btnContinuar = document.getElementById('btnContinuar');
    
    // Validación en tiempo real
    const inputs = form.querySelectorAll('input[required], select[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
    
    // Validación del formulario
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            btnContinuar.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Completa todos los campos';
            btnContinuar.classList.add('btn-warning');
            btnContinuar.classList.remove('btn-primary');
            
            setTimeout(() => {
                btnContinuar.innerHTML = '<i class="bi bi-arrow-right me-2"></i>Continuar a Asientos';
                btnContinuar.classList.remove('btn-warning');
                btnContinuar.classList.add('btn-primary');
            }, 3000);
        } else {
            btnContinuar.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Procesando...';
            btnContinuar.disabled = true;
        }
    });
});
</script>
@endpush
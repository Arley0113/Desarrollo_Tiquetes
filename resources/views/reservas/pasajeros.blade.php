@extends('layouts.app')

@section('title', 'Información del Pasajero')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-fill"></i> Información del Pasajero</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Información del Vuelo -->
                    <div class="alert alert-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="bi bi-airplane-fill"></i> Vuelo:</strong> {{ $vuelo->codigo_vuelo ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong><i class="bi bi-geo-alt-fill"></i> Ruta:</strong> 
                                {{ $vuelo->origen->nombre_lugar }} → {{ $vuelo->destino->nombre_lugar }}
                            </div>
                            <div class="col-md-6 mt-2">
                                <strong><i class="bi bi-calendar-fill"></i> Fecha:</strong> 
                                {{ date('d/m/Y', strtotime($vuelo->fecha_vuelo)) }}
                            </div>
                            <div class="col-md-6 mt-2">
                                <strong><i class="bi bi-clock-fill"></i> Hora:</strong> 
                                {{ date('H:i', strtotime($vuelo->hora)) }}
                            </div>
                        </div>
                    </div>

                    <p class="text-muted mb-4">Completa la información del pasajero principal. Esta información será utilizada para la reserva y el envío de confirmación.</p>

                    @if($errors->any())
                        <x-alert type="danger">
                            <strong>Por favor corrige los siguientes errores:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert>
                    @endif

                    <form action="{{ route('reservas.pasajeros.guardar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_vuelo" value="{{ $vuelo->id_vuelo }}">

                        <h6 class="fw-bold mb-3 text-primary">
                            <i class="bi bi-person-badge"></i> Pasajero Principal
                        </h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="nombre" 
                                       id="nombre" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       placeholder="Ej: Juan"
                                       value="{{ old('nombre') }}" 
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="apellido" 
                                       id="apellido" 
                                       class="form-control @error('apellido') is-invalid @enderror" 
                                       placeholder="Ej: Pérez"
                                       value="{{ old('apellido') }}" 
                                       required>
                                @error('apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       placeholder="tu@email.com"
                                       value="{{ old('email') }}" 
                                       required>
                                <small class="text-muted">Recibirás la confirmación en este correo</small>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="tel" 
                                       name="telefono" 
                                       id="telefono" 
                                       class="form-control @error('telefono') is-invalid @enderror" 
                                       placeholder="+57 300 000 0000"
                                       value="{{ old('telefono') }}" 
                                       pattern="[0-9\+\-\s\(\)]+"
                                       title="Solo números, espacios, paréntesis, + y -"
                                       required>
                                <small class="text-muted">Ej: +57 300 123 4567 o (1) 234-5678</small>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="fecha_nacimiento" 
                                       id="fecha_nacimiento" 
                                       class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                       value="{{ old('fecha_nacimiento') }}" 
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('fecha_nacimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="genero" class="form-label">Género <span class="text-danger">*</span></label>
                                <select name="genero" 
                                        id="genero" 
                                        class="form-select @error('genero') is-invalid @enderror" 
                                        required>
                                    <option value="">Selecciona...</option>
                                    <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('genero')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-light mt-4 border">
                            <i class="bi bi-info-circle text-primary"></i>
                            <strong>Nota:</strong> Asegúrate de que la información ingresada coincida con tu documento de identidad.
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('vuelo.mostrar', $vuelo->id_vuelo) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-continuar">
                                Continuar a Selección de Asientos <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const btnContinuar = document.getElementById('btn-continuar');
    
    // Validación en tiempo real
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
    
    function validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let message = '';
        
        // Validaciones específicas por campo
        switch(field.name) {
            case 'nombre':
            case 'apellido':
                if (!value) {
                    isValid = false;
                    message = 'Este campo es obligatorio';
                } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(value)) {
                    isValid = false;
                    message = 'Solo se permiten letras y espacios';
                }
                break;
                
            case 'email':
                if (!value) {
                    isValid = false;
                    message = 'Este campo es obligatorio';
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                    isValid = false;
                    message = 'Debe ser un correo electrónico válido';
                }
                break;
                
            case 'telefono':
                if (!value) {
                    isValid = false;
                    message = 'Este campo es obligatorio';
                } else if (!/^[0-9\+\-\s\(\)]+$/.test(value)) {
                    isValid = false;
                    message = 'Solo números, espacios, paréntesis, + y -';
                }
                break;
                
            case 'fecha_nacimiento':
                if (!value) {
                    isValid = false;
                    message = 'Este campo es obligatorio';
                } else {
                    const fechaNac = new Date(value);
                    const hoy = new Date();
                    if (fechaNac >= hoy) {
                        isValid = false;
                        message = 'La fecha debe ser anterior a hoy';
                    }
                }
                break;
        }
        
        // Aplicar estilos de validación
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
        }
        
        // Mostrar mensaje de error
        let feedback = field.parentNode.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            field.parentNode.appendChild(feedback);
        }
        feedback.textContent = message;
        
        return isValid;
    }
    
    // Validación del formulario completo
    form.addEventListener('submit', function(e) {
        let allValid = true;
        
        inputs.forEach(input => {
            if (!validateField(input)) {
                allValid = false;
            }
        });
        
        if (!allValid) {
            e.preventDefault();
            btnContinuar.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Corrige los errores';
            btnContinuar.classList.add('btn-warning');
            btnContinuar.classList.remove('btn-primary');
            
            setTimeout(() => {
                btnContinuar.innerHTML = 'Continuar a Selección de Asientos <i class="bi bi-arrow-right"></i>';
                btnContinuar.classList.remove('btn-warning');
                btnContinuar.classList.add('btn-primary');
            }, 3000);
        }
    });
});
</script>
@endpush
@extends('layouts.app')

@section('title', 'Crear Cuenta')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="fw-bold text-dark">Crea tu cuenta</h2>
                            <p class="text-muted">Únete a VuelosYa y comienza a viajar</p>
                        </div>

                        <!-- Formulario de Registro -->
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf
                            
                            <div class="row g-3">
                                <!-- Nombres -->
                                <div class="col-md-6">
                                    <label for="nombres" class="form-label fw-semibold">
                                        <i class="bi bi-person me-2"></i>Nombres *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-person text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 @error('nombres') is-invalid @enderror" 
                                               id="nombres" 
                                               name="nombres" 
                                               placeholder="Tu nombre"
                                               value="{{ old('nombres') }}" 
                                               required 
                                               autocomplete="given-name">
                                    </div>
                                    @error('nombres')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Primer Apellido -->
                                <div class="col-md-6">
                                    <label for="primer_apellido" class="form-label fw-semibold">
                                        <i class="bi bi-person me-2"></i>Primer Apellido *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-person text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 @error('primer_apellido') is-invalid @enderror" 
                                               id="primer_apellido" 
                                               name="primer_apellido" 
                                               placeholder="Tu apellido"
                                               value="{{ old('primer_apellido') }}" 
                                               required 
                                               autocomplete="family-name">
                                    </div>
                                    @error('primer_apellido')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Correo -->
                                <div class="col-md-6">
                                    <label for="correo" class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-2"></i>Correo Electrónico *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-envelope text-muted"></i>
                                        </span>
                                        <input type="email" 
                                               class="form-control border-start-0 @error('correo') is-invalid @enderror" 
                                               id="correo" 
                                               name="correo" 
                                               placeholder="tu@email.com"
                                               value="{{ old('correo') }}" 
                                               required 
                                               autocomplete="email">
                                    </div>
                                    @error('correo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Documento -->
                                <div class="col-md-6">
                                    <label for="documento" class="form-label fw-semibold">
                                        <i class="bi bi-card-text me-2"></i>Documento *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-card-text text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 @error('documento') is-invalid @enderror" 
                                               id="documento" 
                                               name="documento" 
                                               placeholder="12345678"
                                               value="{{ old('documento') }}" 
                                               required>
                                    </div>
                                    @error('documento')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Contraseña -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="bi bi-lock me-2"></i>Contraseña *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock text-muted"></i>
                                        </span>
                                        <input type="password" 
                                               class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Mínimo 6 caracteres"
                                               required 
                                               autocomplete="new-password">
                                        <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="bi bi-lock-fill me-2"></i>Confirmar Contraseña *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-lock-fill text-muted"></i>
                                        </span>
                                        <input type="password" 
                                               class="form-control border-start-0 @error('password_confirmation') is-invalid @enderror" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               placeholder="Repite tu contraseña"
                                               required 
                                               autocomplete="new-password">
                                        <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePasswordConfirm">
                                            <i class="bi bi-eye" id="toggleIconConfirm"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tipo de Usuario -->
                                <div class="col-12">
                                    <label for="id_rol" class="form-label fw-semibold">
                                        <i class="bi bi-person-badge me-2"></i>Tipo de Usuario *
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-person-badge text-muted"></i>
                                        </span>
                                        <select class="form-select border-start-0 @error('id_rol') is-invalid @enderror" 
                                                id="id_rol" 
                                                name="id_rol" 
                                                required>
                                            <option value="">Selecciona tu tipo de usuario</option>
                                            @foreach($roles as $rol)
                                                <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                                                    {{ $rol->nombre_rol }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('id_rol')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Términos y Condiciones -->
                            <div class="form-check mt-4 mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label text-muted" for="terms">
                                    Acepto los <a href="#" class="text-primary">términos y condiciones</a> y la <a href="#" class="text-primary">política de privacidad</a>
                                </label>
                            </div>

                            <!-- Botón de Registro -->
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3 mb-3" id="registerBtn">
                                <i class="bi bi-person-plus me-2"></i>
                                Crear Cuenta
                            </button>

                            <!-- Enlaces adicionales -->
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    ¿Ya tienes cuenta? 
                                    <a href="{{ route('login.form') }}" class="text-primary fw-semibold text-decoration-none">
                                        Inicia sesión aquí
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="text-center mt-4">
                    <p class="text-white-50 mb-0">
                        <i class="bi bi-shield-check me-1"></i>
                        Tus datos están protegidos con encriptación SSL
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .min-vh-100 {
        min-height: 100vh;
    }
    
    .card {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    
    .input-group-text {
        background: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .form-control, .form-select {
        border-color: #dee2e6;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleIconConfirm = document.getElementById('toggleIconConfirm');
    const registerForm = document.getElementById('registerForm');
    const registerBtn = document.getElementById('registerBtn');
    
    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });
    
    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmInput.setAttribute('type', type);
        
        toggleIconConfirm.classList.toggle('bi-eye');
        toggleIconConfirm.classList.toggle('bi-eye-slash');
    });
    
    // Password confirmation validation
    passwordConfirmInput.addEventListener('input', function() {
        const password = passwordInput.value;
        const confirmPassword = this.value;
        
        if (confirmPassword && password !== confirmPassword) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    // Form validation
    registerForm.addEventListener('submit', function(e) {
        const password = passwordInput.value;
        const confirmPassword = passwordConfirmInput.value;
        const terms = document.getElementById('terms').checked;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            registerBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Las contraseñas no coinciden';
            registerBtn.classList.add('btn-warning');
            registerBtn.classList.remove('btn-primary');
            
            setTimeout(() => {
                registerBtn.innerHTML = '<i class="bi bi-person-plus me-2"></i>Crear Cuenta';
                registerBtn.classList.remove('btn-warning');
                registerBtn.classList.add('btn-primary');
            }, 3000);
        } else if (!terms) {
            e.preventDefault();
            registerBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Acepta los términos';
            registerBtn.classList.add('btn-warning');
            registerBtn.classList.remove('btn-primary');
            
            setTimeout(() => {
                registerBtn.innerHTML = '<i class="bi bi-person-plus me-2"></i>Crear Cuenta';
                registerBtn.classList.remove('btn-warning');
                registerBtn.classList.add('btn-primary');
            }, 3000);
        } else {
            registerBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creando cuenta...';
            registerBtn.disabled = true;
        }
    });
    
    // Real-time validation
    const emailInput = document.getElementById('correo');
    emailInput.addEventListener('blur', function() {
        const email = this.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    // Document validation
    const documentInput = document.getElementById('documento');
    documentInput.addEventListener('input', function() {
        const value = this.value;
        const numberRegex = /^[0-9]+$/;
        
        if (value && !numberRegex.test(value)) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
@endpush

@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="bi bi-airplane-fill text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="fw-bold text-dark">Bienvenido de vuelta</h2>
                            <p class="text-muted">Inicia sesión en tu cuenta</p>
                        </div>

                        <!-- Formulario de Login -->
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            
                            <!-- Campo Email -->
                            <div class="mb-4">
                                <label for="correo" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-2"></i>Correo Electrónico
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
                                           autocomplete="email"
                                           autofocus>
                                </div>
                                @error('correo')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Campo Contraseña -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock me-2"></i>Contraseña
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Tu contraseña"
                                           required 
                                           autocomplete="current-password">
                                    <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Recordar sesión -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label text-muted" for="remember">
                                    Recordar mi sesión
                                </label>
                            </div>

                            <!-- Botón de Login -->
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3 mb-3" id="loginBtn">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Iniciar Sesión
                            </button>

                            <!-- Enlaces adicionales -->
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    ¿No tienes cuenta? 
                                    <a href="{{ route('register.form') }}" class="text-primary fw-semibold text-decoration-none">
                                        Regístrate aquí
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
    
    .form-control:focus {
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
    
    .form-control {
        border-color: #dee2e6;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    
    // Toggle password visibility
    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });
    
    // Form validation
    loginForm.addEventListener('submit', function(e) {
        const email = document.getElementById('correo').value;
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            e.preventDefault();
            loginBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Completa todos los campos';
            loginBtn.classList.add('btn-warning');
            loginBtn.classList.remove('btn-primary');
            
            setTimeout(() => {
                loginBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión';
                loginBtn.classList.remove('btn-warning');
                loginBtn.classList.add('btn-primary');
            }, 3000);
        } else {
            loginBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Iniciando sesión...';
            loginBtn.disabled = true;
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
});
</script>
@endpush

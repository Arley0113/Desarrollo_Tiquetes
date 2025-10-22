@extends('layouts.app')

@section('title', 'Crear Cuenta')

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <!-- Encabezado -->
                        <div class="text-center mb-4">
                            <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                            <h2 class="fw-bold text-dark mt-2">Crea tu cuenta</h2>
                            <p class="text-muted mb-0">Únete a VuelosYa y comienza a viajar</p>
                        </div>

                        <!-- Formulario de Registro -->
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf

                            <div class="row g-4">
                                <!-- COLUMNA IZQUIERDA -->
                                <div class="col-md-6">
                                    <!-- Nombres -->
                                    <label for="nombres" class="form-label fw-semibold">
                                        <i class="bi bi-person me-2"></i>Nombres *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                                        <input type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres" value="{{ old('nombres') }}" required>
                                    </div>
                                    @error('nombres') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                                    <!-- Primer Apellido -->
                                    <label for="primer_apellido" class="form-label fw-semibold">
                                        <i class="bi bi-person me-2"></i>Primer Apellido *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                                        <input type="text" class="form-control @error('primer_apellido') is-invalid @enderror" name="primer_apellido" value="{{ old('primer_apellido') }}" required>
                                    </div>
                                    @error('primer_apellido') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                                    <!-- Segundo Apellido -->
                                    <label for="segundo_apellido" class="form-label fw-semibold">
                                        <i class="bi bi-person me-2"></i>Segundo Apellido
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                                        <input type="text" class="form-control" name="segundo_apellido" value="{{ old('segundo_apellido') }}">
                                    </div>

                                    <!-- Fecha Nacimiento -->
                                    <label for="fecha_nacimiento" class="form-label fw-semibold">
                                        <i class="bi bi-calendar me-2"></i>Fecha de Nacimiento *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-calendar text-muted"></i></span>
                                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                                    </div>
                                    @error('fecha_nacimiento') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                                    <!-- Género -->
                                    <label for="genero" class="form-label fw-semibold">
                                        <i class="bi bi-gender-ambiguous me-2"></i>Género *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-gender-ambiguous text-muted"></i></span>
                                        <select class="form-select @error('genero') is-invalid @enderror" name="genero" required>
                                            <option value="">Selecciona</option>
                                            <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                            <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                            <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                        </select>
                                    </div>
                                    @error('genero') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <!-- COLUMNA DERECHA -->
                                <div class="col-md-6">
                                    <!-- Tipo Documento -->
                                    <label for="tipo_documento" class="form-label fw-semibold">
                                        <i class="bi bi-card-heading me-2"></i>Tipo de Documento *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-card-heading text-muted"></i></span>
                                        <select class="form-select @error('tipo_documento') is-invalid @enderror" name="tipo_documento" required>
                                            <option value="">Selecciona</option>
                                            <option value="CC" {{ old('tipo_documento') == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                            <option value="TI" {{ old('tipo_documento') == 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                                            <option value="CE" {{ old('tipo_documento') == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                            <option value="PAS" {{ old('tipo_documento') == 'PAS' ? 'selected' : '' }}>Pasaporte</option>
                                        </select>
                                    </div>
                                    @error('tipo_documento') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                                    <!-- Documento -->
                                    <label for="documento" class="form-label fw-semibold">
                                        <i class="bi bi-card-text me-2"></i>Número de Documento *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-card-text text-muted"></i></span>
                                        <input type="text" class="form-control @error('documento') is-invalid @enderror" name="documento" value="{{ old('documento') }}" required>
                                    </div>
                                    @error('documento') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                                    <!-- Celular -->
                                    <label for="celular" class="form-label fw-semibold">
                                        <i class="bi bi-phone me-2"></i>Celular *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-phone text-muted"></i></span>
                                        <input type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular') }}" required>
                                    </div>
                                    @error('celular') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                                    <!-- Correo -->
                                    <label for="correo" class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-2"></i>Correo Electrónico *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-envelope text-muted"></i></span>
                                        <input type="email" class="form-control @error('correo') is-invalid @enderror" name="correo" value="{{ old('correo') }}" required>
                                    </div>
                                    @error('correo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                                    <!-- Contraseña -->
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="bi bi-lock me-2"></i>Contraseña *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                    </div>
                                    @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                                    <!-- Confirmar Contraseña -->
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="bi bi-lock-fill me-2"></i>Confirmar Contraseña *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-lock-fill text-muted"></i></span>
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </div>

                                    <!-- Tipo de Usuario -->
                                    <label for="id_rol" class="form-label fw-semibold">
                                        <i class="bi bi-person-badge me-2"></i>Tipo de Usuario *
                                    </label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><i class="bi bi-person-badge text-muted"></i></span>
                                        <select class="form-select @error('id_rol') is-invalid @enderror" name="id_rol" required>
                                            <option value="">Selecciona tu tipo de usuario</option>
                                            @foreach($roles as $rol)
                                                <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>{{ $rol->nombre_rol }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('id_rol') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Términos y Botón -->
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label text-muted" for="terms">
                                    Acepto los <a href="#" class="text-primary">términos y condiciones</a> y la <a href="#" class="text-primary">política de privacidad</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 mt-4 fw-semibold rounded-3">
                                <i class="bi bi-person-plus me-2"></i>Crear Cuenta
                            </button>
                        </form>
                    </div>
                </div>

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

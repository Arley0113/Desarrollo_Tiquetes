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

                <!-- Pasajero Principal -->
                <div class="mb-4">
                    <h5 class="mb-3 fw-bold">Pasajero 1 (Principal)</h5>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold">Nombre *</label>
                            <input type="text" name="nombre" id="nombre" class="form-control form-control-lg" placeholder="Nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="apellido" class="form-label fw-semibold">Apellido *</label>
                            <input type="text" name="apellido" id="apellido" class="form-control form-control-lg" placeholder="Apellido" value="{{ old('apellido') }}" required>
                            @error('apellido')
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

                        <!-- Ciudad y Departamento con Autocomplete -->
                        <div class="col-md-6 position-relative">
                            <label for="ciudad" class="form-label fw-semibold">Ciudad *</label>
                            <input type="text" id="ciudad" name="ciudad" class="form-control form-control-lg" placeholder="Ciudad de residencia" autocomplete="off" required>
                            <div id="lista-ciudades" class="list-group position-absolute z-index-10 w-100"></div>
                            @error('ciudad')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 position-relative">
                            <label for="departamento" class="form-label fw-semibold">Departamento *</label>
                            <input type="text" id="departamento" name="departamento" class="form-control form-control-lg" placeholder="Departamento" autocomplete="off" required>
                            <div id="lista-departamentos" class="list-group position-absolute z-index-10 w-100"></div>
                            @error('departamento')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
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

<script>
const ciudades = ["Bogotá", "Medellín", "Cali", "Barranquilla", "Cartagena", "Bucaramanga", "Pereira", "Manizales"];
const departamentos = ["Cundinamarca", "Antioquia", "Valle del Cauca", "Atlántico", "Bolívar", "Santander", "Risaralda", "Caldas"];

function autocomplete(input, lista, opciones) {
    input.addEventListener('input', function() {
        lista.innerHTML = '';
        const val = this.value.toLowerCase();
        if(!val) return;
        opciones.filter(opt => opt.toLowerCase().includes(val)).forEach(opt => {
            const item = document.createElement('button');
            item.type = 'button';
            item.classList.add('list-group-item', 'list-group-item-action');
            item.textContent = opt;
            item.addEventListener('click', () => {
                input.value = opt;
                lista.innerHTML = '';
            });
            lista.appendChild(item);
        });
    });

    document.addEventListener('click', (e) => {
        if(e.target !== input) lista.innerHTML = '';
    });
}

autocomplete(document.getElementById('ciudad'), document.getElementById('lista-ciudades'), ciudades);
autocomplete(document.getElementById('departamento'), document.getElementById('lista-departamentos'), departamentos);
</script>
@endsection

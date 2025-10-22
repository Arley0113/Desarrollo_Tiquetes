@extends('layouts.app')

@section('title', 'Vuelos de ' . $origen->nombre_lugar . ' a ' . $destino->nombre_lugar)

@section('content')
<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">{{ $origen->nombre_lugar }} → {{ $destino->nombre_lugar }}</h4>
        <span class="badge bg-success">{{ $vuelos->count() }} vuelos disponibles</span>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm p-3 mb-4">
                <h6 class="fw-bold mb-3">Filtros de Búsqueda</h6>
                
                {{-- Rango de Precio --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Rango de Precio</label>
                    <input type="range" class="form-range" min="0" max="{{ $precioMaximo }}" id="rangoPrecio" value="{{ $precioMaximo }}">
                    <div class="d-flex justify-content-between mt-1">
                        <span id="precioMinimo">$0</span>
                        <span id="precioMaximo">${{ number_format($precioMaximo, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-center mt-2">
                        <span class="badge bg-primary" id="precioActual">Hasta ${{ number_format($precioMaximo, 0, ',', '.') }}</span>
                    </div>
                </div>

                <hr>
                
                {{-- Tipo de Vuelo --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Tipo de Vuelo</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="vuelosDirectos" checked>
                        <label class="form-check-label" for="vuelosDirectos">Solo vuelos directos</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="vuelosConEscala">
                        <label class="form-check-label" for="vuelosConEscala">Vuelos con escala</label>
                    </div>
                </div>

                {{-- Comodidades --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Comodidades</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="wifi">
                        <label class="form-check-label" for="wifi">WiFi disponible</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="reembolsable">
                        <label class="form-check-label" for="reembolsable">Reembolsable</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="asientosDisponibles">
                        <label class="form-check-label" for="asientosDisponibles">Con asientos disponibles</label>
                    </div>
                </div>

                {{-- Ordenar por --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Ordenar por</label>
                    <select class="form-select" id="ordenarPor">
                        <option value="precio">Precio (menor a mayor)</option>
                        <option value="precio-desc">Precio (mayor a menor)</option>
                        <option value="hora">Hora de salida</option>
                        <option value="duracion">Duración</option>
                    </select>
                </div>

                <button class="btn btn-outline-secondary w-100 mt-3" id="limpiarFiltros">Limpiar Filtros</button>
            </div>
        </div>

        <div class="col-md-9">
            {{-- Contador de resultados --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Resultados encontrados: <span id="contadorResultados">{{ $vuelos->count() }}</span></h5>
                <div class="text-muted">
                    <small>Mostrando vuelos para {{ $request->fecha }}</small>
                </div>
            </div>

            {{-- Lista de vuelos --}}
            <div id="lista-vuelos">
                @foreach ($vuelos as $vuelo)
                    <div class="card vuelo shadow-sm p-3 mb-3" 
                         data-precio="{{ $vuelo->precio->precio_ida ?? 0 }}" 
                         data-directo="{{ $vuelo->directo ? 'true' : 'false' }}" 
                         data-wifi="{{ $vuelo->wifi ? 'true' : 'false' }}" 
                         data-reembolsable="{{ $vuelo->reembolsable ? 'true' : 'false' }}"
                         data-hora="{{ $vuelo->hora }}"
                         data-duracion="{{ $vuelo->duracion ?? '2h 30m' }}"
                         data-asientos-disponibles="{{ $vuelo->asientosDisponibles() ?? 0 }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="icono me-3">
                                    <i class="bi bi-airplane fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $vuelo->avion->nombre ?? 'Aerolínea' }}</h6>
                                    <small class="text-muted">{{ $vuelo->codigo_vuelo ?? 'XX0000' }}</small>
                                    <div class="mt-1">
                                        @if($vuelo->wifi)
                                            <span class="badge bg-success me-1">WiFi</span>
                                        @endif
                                        @if($vuelo->reembolsable)
                                            <span class="badge bg-info me-1">Reembolsable</span>
                                        @endif
                                        @if($vuelo->directo)
                                            <span class="badge bg-warning">Directo</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h6 class="fw-bold">{{ date('H:i', strtotime($vuelo->hora)) }}</h6>
                                <small class="text-muted">{{ $origen->nombre_lugar }}</small>
                            </div>
                            <div class="text-center">
                                <small class="text-muted">{{ $vuelo->duracion ?? '2h 30m' }}</small>
                                <div class="mt-1">
                                    @if($vuelo->directo)
                                        <i class="bi bi-arrow-right text-success"></i>
                                    @else
                                        <i class="bi bi-arrow-right text-warning"></i>
                                        <small class="text-warning">Con escala</small>
                                    @endif
                                </div>
                            </div>
                            <div class="text-center">
                                <h6 class="fw-bold">{{ date('H:i', strtotime($vuelo->hora_llegada ?? $vuelo->hora)) }}</h6>
                                <small class="text-muted">{{ $destino->nombre_lugar }}</small>
                            </div>
                            <div class="text-end">
                                <h5 class="fw-bold text-primary">${{ number_format($vuelo->precio->precio_ida ?? 0, 0, ',', '.') }}</h5>
                                <small class="text-muted">{{ $vuelo->asientosDisponibles() ?? 0 }} asientos disponibles</small>
                                <div class="mt-2">
                                    <a href="{{ route('vuelo.mostrar', $vuelo->id) }}" class="btn btn-primary btn-sm">Seleccionar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Mensaje cuando no hay resultados --}}
            <div id="sin-resultados" class="text-center py-5" style="display: none;">
                <i class="bi bi-search fs-1 text-muted"></i>
                <h5 class="text-muted mt-3">No se encontraron vuelos</h5>
                <p class="text-muted">Intenta ajustar los filtros para ver más resultados</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const vuelos = document.querySelectorAll('.vuelo');
    const rangoPrecio = document.getElementById('rangoPrecio');
    const precioActual = document.getElementById('precioActual');
    const contadorResultados = document.getElementById('contadorResultados');
    const listaVuelos = document.getElementById('lista-vuelos');
    const sinResultados = document.getElementById('sin-resultados');
    
    // Obtener precio máximo de los datos
    const precioMaximo = Math.max(...Array.from(vuelos).map(v => parseInt(v.dataset.precio)));
    
    // Actualizar rango de precio
    rangoPrecio.max = precioMaximo;
    rangoPrecio.value = precioMaximo;
    
    // Función para filtrar vuelos
    function filtrarVuelos() {
        const precioMax = parseInt(rangoPrecio.value);
        const vuelosDirectos = document.getElementById('vuelosDirectos').checked;
        const vuelosConEscala = document.getElementById('vuelosConEscala').checked;
        const wifi = document.getElementById('wifi').checked;
        const reembolsable = document.getElementById('reembolsable').checked;
        const asientosDisponibles = document.getElementById('asientosDisponibles').checked;
        const ordenarPor = document.getElementById('ordenarPor').value;
        
        let vuelosVisibles = Array.from(vuelos);
        
        // Filtrar por precio
        vuelosVisibles = vuelosVisibles.filter(vuelo => {
            return parseInt(vuelo.dataset.precio) <= precioMax;
        });
        
        // Filtrar por tipo de vuelo
        if (vuelosDirectos && !vuelosConEscala) {
            vuelosVisibles = vuelosVisibles.filter(vuelo => vuelo.dataset.directo === 'true');
        } else if (!vuelosDirectos && vuelosConEscala) {
            vuelosVisibles = vuelosVisibles.filter(vuelo => vuelo.dataset.directo === 'false');
        }
        
        // Filtrar por comodidades
        if (wifi) {
            vuelosVisibles = vuelosVisibles.filter(vuelo => vuelo.dataset.wifi === 'true');
        }
        
        if (reembolsable) {
            vuelosVisibles = vuelosVisibles.filter(vuelo => vuelo.dataset.reembolsable === 'true');
        }
        
        if (asientosDisponibles) {
            vuelosVisibles = vuelosVisibles.filter(vuelo => parseInt(vuelo.dataset.asientosDisponibles) > 0);
        }
        
        // Ordenar resultados
        vuelosVisibles.sort((a, b) => {
            switch(ordenarPor) {
                case 'precio':
                    return parseInt(a.dataset.precio) - parseInt(b.dataset.precio);
                case 'precio-desc':
                    return parseInt(b.dataset.precio) - parseInt(a.dataset.precio);
                case 'hora':
                    return a.dataset.hora.localeCompare(b.dataset.hora);
                case 'duracion':
                    return a.dataset.duracion.localeCompare(b.dataset.duracion);
                default:
                    return 0;
            }
        });
        
        // Mostrar/ocultar vuelos
        vuelos.forEach(vuelo => {
            if (vuelosVisibles.includes(vuelo)) {
                vuelo.style.display = 'block';
            } else {
                vuelo.style.display = 'none';
            }
        });
        
        // Actualizar contador
        contadorResultados.textContent = vuelosVisibles.length;
        
        // Mostrar mensaje si no hay resultados
        if (vuelosVisibles.length === 0) {
            sinResultados.style.display = 'block';
            listaVuelos.style.display = 'none';
        } else {
            sinResultados.style.display = 'none';
            listaVuelos.style.display = 'block';
        }
    }
    
    // Event listeners
    rangoPrecio.addEventListener('input', function() {
        precioActual.textContent = `Hasta $${parseInt(this.value).toLocaleString()}`;
        filtrarVuelos();
    });
    
    document.getElementById('vuelosDirectos').addEventListener('change', filtrarVuelos);
    document.getElementById('vuelosConEscala').addEventListener('change', filtrarVuelos);
    document.getElementById('wifi').addEventListener('change', filtrarVuelos);
    document.getElementById('reembolsable').addEventListener('change', filtrarVuelos);
    document.getElementById('asientosDisponibles').addEventListener('change', filtrarVuelos);
    document.getElementById('ordenarPor').addEventListener('change', filtrarVuelos);
    
    // Limpiar filtros
    document.getElementById('limpiarFiltros').addEventListener('click', function() {
        // Resetear checkboxes
        document.querySelectorAll('.form-check-input').forEach(cb => cb.checked = false);
        document.getElementById('vuelosDirectos').checked = true; // Mantener vuelos directos por defecto
        
        // Resetear rango de precio
        rangoPrecio.value = precioMaximo;
        precioActual.textContent = `Hasta $${precioMaximo.toLocaleString()}`;
        
        // Resetear ordenamiento
        document.getElementById('ordenarPor').value = 'precio';
        
        // Aplicar filtros
        filtrarVuelos();
    });
    
    // Aplicar filtros iniciales
    filtrarVuelos();
});
</script>
@endsection

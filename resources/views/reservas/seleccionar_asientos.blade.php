@extends('layouts.app')

@section('title', 'Seleccionar Asientos')

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
                                <small class="text-muted">Precio base por pasajero</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Mapa de asientos -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="bi bi-grid-3x3-gap me-2"></i>
                            Selecciona tus asientos
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Leyenda -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-3 justify-content-center">
                                    <div class="d-flex align-items-center">
                                        <div class="seat-legend disponible me-2"></div>
                                        <span class="small">Disponible</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="seat-legend seleccionado me-2"></div>
                                        <span class="small">Seleccionado</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="seat-legend ocupado me-2"></div>
                                        <span class="small">Ocupado</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="seat-legend extra me-2"></div>
                                        <span class="small">Espacio Extra (+$25)</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="seat-legend emergencia me-2"></div>
                                        <span class="small">Salida Emergencia (+$15)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mapa de asientos -->
                        <div class="seat-map-container">
                            <div class="text-center mb-3">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-arrow-up me-1"></i>Frente
                                </button>
                            </div>
                            
                            <div class="seat-map">
                                <!-- Columnas A-F -->
                                <div class="seat-row-header">
                                    <div class="seat-column-label"></div>
                                    <div class="seat-column-label">A</div>
                                    <div class="seat-column-label">B</div>
                                    <div class="seat-column-label">C</div>
                                    <div class="seat-column-label">D</div>
                                    <div class="seat-column-label">E</div>
                                    <div class="seat-column-label">F</div>
                                </div>

                                <!-- Filas de asientos -->
                                @foreach($asientos as $fila => $asientosFila)
                                <div class="seat-row">
                                    <div class="seat-row-number">{{ $fila }}</div>
                                    @for($col = 0; $col < 6; $col++)
                                        @php
                                            $letra = chr(65 + $col); // A, B, C, D, E, F
                                            $asiento = $asientosFila->where('columna', $letra)->first();
                                        @endphp
                                        @if($asiento)
                                            <div class="seat-container">
                                                <button type="button" 
                                                        class="seat-btn {{ $asiento->estado }} {{ $asiento->tipo_asiento }}"
                                                        data-asiento-id="{{ $asiento->id_asiento }}"
                                                        data-fila="{{ $asiento->fila }}"
                                                        data-columna="{{ $asiento->columna }}"
                                                        data-tipo="{{ $asiento->tipo_asiento }}"
                                                        data-precio="{{ $asiento->precio_adicional }}"
                                                        onclick="seleccionarAsiento(this)"
                                                        {{ $asiento->estado === 'ocupado' ? 'disabled="disabled"' : '' }}>
                                                    @if($asiento->estado === 'ocupado')
                                                        <i class="bi bi-x"></i>
                                                    @else
                                                        {{ $asiento->fila }}{{ $asiento->columna }}
                                                    @endif
                                                </button>
                                            </div>
                                        @else
                                            <div class="seat-container">
                                                <div class="seat-empty"></div>
                                            </div>
                                        @endif
                                    @endfor
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen de selección -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="bi bi-list-check me-2"></i>
                            Resumen de Selección
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Progreso -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="text-muted">Progreso</small>
                                <small class="text-muted" id="progreso-texto">0/{{ $cantidadPasajeros }}</small>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary" id="progreso-bar" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Asientos seleccionados -->
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Asientos seleccionados:</h6>
                            <div id="asientos-seleccionados" class="text-muted">
                                Ninguno
                            </div>
                        </div>

                        <!-- Precio total -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Precio base:</span>
                                <span id="precio-base">${{ number_format($vuelo->precio->precio_ida, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center" id="precio-extra-container" style="display: none;">
                                <span class="text-muted">Extras:</span>
                                <span id="precio-extra">$0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Total a Pagar:</strong>
                                <strong class="text-primary h5 mb-0" id="precio-total">${{ number_format($vuelo->precio->precio_ida, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <!-- Mensaje de selección -->
                        <div id="mensaje-seleccion" class="alert alert-warning">
                            <i class="bi bi-info-circle me-2"></i>
                            Selecciona {{ $cantidadPasajeros }} asiento{{ $cantidadPasajeros > 1 ? 's' : '' }} más
                        </div>

                        <!-- Botón continuar -->
                        <form method="POST" action="{{ route('reservas.asientos.guardar', $vuelo->id_vuelo) }}" id="form-asientos">
                            @csrf
                            <input type="hidden" name="asientos" id="asientos-input">
                            <button type="submit" class="btn btn-primary w-100" id="btn-continuar" disabled>
                                <i class="bi bi-arrow-right me-2"></i>Continuar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navegación -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('vuelo.mostrar', $vuelo->id_vuelo) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Anterior
                    </a>
                    <div class="text-center">
                        <div class="h4 text-primary mb-0" id="total-display">${{ number_format($vuelo->precio->precio_ida, 0, ',', '.') }}</div>
                        <small class="text-muted">Total a Pagar</small>
                    </div>
                    <button type="submit" form="form-asientos" class="btn btn-primary" id="btn-continuar-footer" disabled>
                        Continuar <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .seat-map-container {
        max-width: 100%;
        overflow-x: auto;
    }

    .seat-map {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 400px;
    }

    .seat-row-header {
        display: flex;
        gap: 8px;
        margin-bottom: 8px;
    }

    .seat-column-label {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #6c757d;
    }

    .seat-row {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .seat-row-number {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #6c757d;
    }

    .seat-container {
        width: 40px;
        height: 40px;
    }

    .seat-btn {
        width: 100%;
        height: 100%;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .seat-btn:hover:not(:disabled) {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .seat-btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Estados de asientos */
    .seat-btn.disponible {
        background-color: #fff;
        border: 1px solid #ccc;
        cursor: pointer;
        color: #495057;
    }

    .seat-btn.seleccionado {
        background-color: #28a745;
        border: 1px solid #28a745;
        color: white;
        cursor: pointer;
    }

    .seat-btn.ocupado {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        color: #aaa;
        cursor: not-allowed;
    }

    .seat-btn.extra {
        background: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .seat-btn.emergencia {
        background: #28a745;
        border-color: #28a745;
        color: white;
    }

    /* Leyenda */
    .seat-legend {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }

    .seat-legend.disponible {
        background: white;
        border-color: #dee2e6;
    }

    .seat-legend.seleccionado {
        background: #6f42c1;
        border-color: #6f42c1;
    }

    .seat-legend.ocupado {
        background: #6c757d;
        border-color: #6c757d;
    }

    .seat-legend.extra {
        background: #ffc107;
        border-color: #ffc107;
    }

    .seat-legend.emergencia {
        background: #28a745;
        border-color: #28a745;
    }

    .seat-empty {
        width: 100%;
        height: 100%;
    }

    .sticky-top {
        position: sticky;
        top: 20px;
    }

    .progress {
        border-radius: 10px;
    }

    .progress-bar {
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
// Variables globales
const asientosSeleccionados = [];
const cantidadPasajeros = {{ $cantidadPasajeros }};
const precioBase = {{ $vuelo->precio->precio_base }};

// Función para seleccionar/deseleccionar asientos
function seleccionarAsiento(btn) {
    const asientoId = btn.getAttribute('data-asiento-id');
    const fila = btn.getAttribute('data-fila');
    const columna = btn.getAttribute('data-columna');
    const tipo = btn.getAttribute('data-tipo') || 'normal';
    const precio = parseFloat(btn.getAttribute('data-precio')) || 0;
    
    console.log('Click en asiento:', fila + columna);
    
    // Verificar si el asiento ya está seleccionado
    if (btn.classList.contains('seleccionado')) {
        // Deseleccionar
        btn.classList.remove('seleccionado');
        btn.classList.add('disponible');
        
        // Eliminar de la lista
        const index = asientosSeleccionados.findIndex(a => a.id === asientoId);
        if (index > -1) {
            asientosSeleccionados.splice(index, 1);
        }
    } else {
        // Si ya se alcanzó el límite, deseleccionar el primero
        if (asientosSeleccionados.length >= cantidadPasajeros) {
            const primerAsiento = asientosSeleccionados[0];
            const primerBtn = document.querySelector(`.seat-btn[data-asiento-id="${primerAsiento.id}"]`);
            if (primerBtn) {
                primerBtn.classList.remove('seleccionado');
                primerBtn.classList.add('disponible');
            }
            asientosSeleccionados.shift();
        }
        
        // Seleccionar el nuevo
        btn.classList.remove('disponible');
        btn.classList.add('seleccionado');
        
        // Añadir a la lista
        asientosSeleccionados.push({
            id: asientoId,
            fila: fila,
            columna: columna,
            tipo: tipo,
            precio: precio
        });
    }
    
    // Actualizar la interfaz
    actualizarInterfaz();
    
    return false; // Prevenir comportamiento por defecto
}

// Función para actualizar la interfaz con los asientos seleccionados
function actualizarInterfaz() {
    // Actualizar lista de asientos seleccionados
    const listaAsientos = document.getElementById('lista-asientos-seleccionados');
    listaAsientos.innerHTML = '';
    
    // Calcular precio total
    let precioTotal = cantidadPasajeros * precioBase;
    
    // Mostrar asientos seleccionados
    asientosSeleccionados.forEach(asiento => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `
            <span>Asiento ${asiento.fila}${asiento.columna} (${asiento.tipo})</span>
            <span>+$${asiento.precio.toFixed(2)}</span>
        `;
        listaAsientos.appendChild(li);
        
        // Sumar al precio total
        precioTotal += parseFloat(asiento.precio);
    });
    
    // Actualizar contador de asientos
    document.getElementById('contador-asientos').textContent = `${asientosSeleccionados.length}/${cantidadPasajeros}`;
    
    // Actualizar precio total
    document.getElementById('precio-total').textContent = `$${precioTotal.toFixed(2)}`;
    
    // Actualizar campo oculto con los IDs de asientos
    const asientosInput = document.getElementById('asientos_seleccionados');
    asientosInput.value = asientosSeleccionados.map(a => a.id).join(',');
    
    // Habilitar/deshabilitar botón continuar
    const btnContinuar = document.getElementById('btn-continuar');
    if (asientosSeleccionados.length === cantidadPasajeros) {
        btnContinuar.disabled = false;
        btnContinuar.classList.remove('disabled');
    } else {
        btnContinuar.disabled = true;
        btnContinuar.classList.add('disabled');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Sistema de selección de asientos inicializando');
    console.log('Pasajeros:', cantidadPasajeros, 'Precio base:', precioBase);
    
    // Inicializar la interfaz
    actualizarInterfaz();
    
    console.log('Sistema de selección de asientos inicializado correctamente');
});
</script>
@endpush

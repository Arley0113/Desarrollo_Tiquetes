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
                                    {{ $vuelo->origen->nombre }} → {{ $vuelo->destino->nombre }}
                                </h4>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($vuelo->fecha_salida)->format('d/m/Y') }} 
                                    <i class="bi bi-clock me-1 ms-3"></i>
                                    {{ \Carbon\Carbon::parse($vuelo->hora_salida)->format('H:i') }}
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="h5 text-primary mb-0">${{ number_format($vuelo->precio->precio_base, 0, ',', '.') }}</div>
                                <small class="text-muted">Precio base</small>
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
                                </div>
                            </div>
                        </div>

                        <!-- Mapa de asientos simplificado -->
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

                                <!-- Solo mostrar las primeras 5 filas para simplificar -->
                                @for($fila = 1; $fila <= 5; $fila++)
                                <div class="seat-row">
                                    <div class="seat-row-number">{{ $fila }}</div>
                                    @for($col = 0; $col < 6; $col++)
                                        @php
                                            $letra = chr(65 + $col); // A, B, C, D, E, F
                                            $asiento = $asientos->get($fila)->where('columna', $letra)->first();
                                        @endphp
                                        @if($asiento)
                                            <div class="seat-container">
                                                <button type="button" 
                                                        class="seat-btn {{ $asiento->estado }}"
                                                        data-asiento-id="{{ $asiento->id_asiento }}"
                                                        data-fila="{{ $asiento->fila }}"
                                                        data-columna="{{ $asiento->columna }}"
                                                        data-precio="{{ $asiento->precio_adicional }}"
                                                        @if($asiento->estado === 'ocupado') disabled @endif>
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
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen de selección -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="bi bi-list-check me-2"></i>
                            Resumen de Selección
                        </h5>
                    </div>
                    <div class="card-body">
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
                                <strong>Total a Pagar:</strong>
                                <strong class="text-primary h5 mb-0" id="precio-total">${{ number_format($vuelo->precio->precio_base, 0, ',', '.') }}</strong>
                            </div>
                        </div>

                        <!-- Mensaje de selección -->
                        <div id="mensaje-seleccion" class="alert alert-warning">
                            <i class="bi bi-info-circle me-2"></i>
                            Selecciona 1 asiento más
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
        border-color: #dee2e6;
        background: white;
        color: #495057;
    }

    .seat-btn.seleccionado {
        background: #6f42c1;
        border-color: #6f42c1;
        color: white;
    }

    .seat-btn.ocupado {
        background: #6c757d;
        border-color: #6c757d;
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

    .seat-empty {
        width: 100%;
        height: 100%;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Iniciando selección de asientos...');
    
    const asientosSeleccionados = [];
    const precioBase = {{ $vuelo->precio->precio_base }};
    
    // Elementos del DOM
    const asientosContainer = document.getElementById('asientos-seleccionados');
    const precioTotal = document.getElementById('precio-total');
    const mensajeSeleccion = document.getElementById('mensaje-seleccion');
    const btnContinuar = document.getElementById('btn-continuar');
    const asientosInput = document.getElementById('asientos-input');

    console.log('Elementos encontrados:', {
        asientosContainer: !!asientosContainer,
        precioTotal: !!precioTotal,
        mensajeSeleccion: !!mensajeSeleccion,
        btnContinuar: !!btnContinuar
    });

    // Event listeners para asientos
    const seatButtons = document.querySelectorAll('.seat-btn:not(:disabled)');
    console.log('Botones de asientos encontrados:', seatButtons.length);
    
    seatButtons.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            console.log('Asiento clickeado:', this.dataset.asientoId);
            
            const asientoId = this.dataset.asientoId;
            const fila = this.dataset.fila;
            const columna = this.dataset.columna;
            const precio = parseFloat(this.dataset.precio) || 0;

            if (this.classList.contains('seleccionado')) {
                // Deseleccionar asiento
                console.log('Deseleccionando asiento:', asientoId);
                this.classList.remove('seleccionado');
                this.classList.add('disponible');
                
                const index = asientosSeleccionados.findIndex(a => a.id === asientoId);
                if (index > -1) {
                    asientosSeleccionados.splice(index, 1);
                }
            } else {
                // Limpiar selección anterior
                asientosSeleccionados.length = 0;
                document.querySelectorAll('.seat-btn.seleccionado').forEach(btn => {
                    btn.classList.remove('seleccionado');
                    btn.classList.add('disponible');
                });

                // Seleccionar nuevo asiento
                console.log('Seleccionando asiento:', asientoId);
                this.classList.remove('disponible');
                this.classList.add('seleccionado');
                
                asientosSeleccionados.push({
                    id: asientoId,
                    fila: fila,
                    columna: columna,
                    precio: precio
                });
            }

            actualizarInterfaz();
        });
    });

    function actualizarInterfaz() {
        console.log('Actualizando interfaz...');
        const cantidadSeleccionados = asientosSeleccionados.length;
        
        // Actualizar asientos seleccionados
        if (asientosContainer) {
            if (cantidadSeleccionados === 0) {
                asientosContainer.textContent = 'Ninguno';
            } else {
                asientosContainer.textContent = asientosSeleccionados
                    .map(a => `${a.fila}${a.columna}`)
                    .join(', ');
            }
        }
        
        // Calcular precio total
        const precioExtraTotal = asientosSeleccionados.reduce((sum, a) => sum + a.precio, 0);
        const total = precioBase + precioExtraTotal;
        
        // Actualizar precios
        if (precioTotal) {
            precioTotal.textContent = `$${total.toLocaleString()}`;
        }
        
        // Actualizar mensaje y botones
        if (mensajeSeleccion && btnContinuar) {
            if (cantidadSeleccionados === 1) {
                mensajeSeleccion.className = 'alert alert-success';
                mensajeSeleccion.innerHTML = '<i class="bi bi-check-circle me-2"></i>¡Perfecto! Puedes continuar';
                btnContinuar.disabled = false;
            } else {
                mensajeSeleccion.className = 'alert alert-warning';
                mensajeSeleccion.innerHTML = '<i class="bi bi-info-circle me-2"></i>Selecciona 1 asiento más';
                btnContinuar.disabled = true;
            }
        }
        
        // Actualizar input hidden
        if (asientosInput) {
            asientosInput.value = JSON.stringify(asientosSeleccionados.map(a => a.id));
        }
        
        console.log('Interfaz actualizada. Asientos seleccionados:', asientosSeleccionados);
    }

    // Inicializar interfaz
    actualizarInterfaz();
    
    console.log('Sistema de selección de asientos inicializado');
});
</script>
@endpush

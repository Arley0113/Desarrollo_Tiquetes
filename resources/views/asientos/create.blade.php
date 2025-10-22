@extends('layouts.app')

@section('title', 'Selección de Asientos')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Columna Principal: Selección de Asientos -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Selección de Asientos</h5>
                    <small class="text-muted">Vuelo {{ $vuelo->codigo_vuelo ?? 'N/A' }} - {{ $vuelo->origen->nombre_lugar }} → {{ $vuelo->destino->nombre_lugar }}</small>
                </div>
                <div class="card-body">
                    <!-- Leyenda de Asientos -->
                    <div class="mb-4">
                        <div class="d-flex flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <span class="badge-seat badge-seat-disponible me-2"></span>
                                <small>Disponible</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge-seat badge-seat-seleccionado me-2"></span>
                                <small>Seleccionado</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge-seat badge-seat-ocupado me-2"></span>
                                <small>Ocupado</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge-seat badge-seat-extra me-2"></span>
                                <small>Espacio Extra (+$30.000)</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge-seat badge-seat-emergencia me-2"></span>
                                <small>Salida Emergencia (+$35.000)</small>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de Vista -->
                    <div class="text-center mb-4">
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-airplane"></i> Frente
                        </button>
                    </div>

                    <!-- Mapa de Asientos -->
                    <div class="seat-map">
                        <div class="seat-grid">
                            <!-- Encabezado de Columnas -->
                            <div class="seat-header">
                                <div class="seat-row-number"></div>
                                @foreach(['A', 'B', 'C', 'D', 'E', 'F'] as $column)
                                    <div class="seat-column-label">{{ $column }}</div>
                                @endforeach
                            </div>

                            <!-- Filas de Asientos -->
                            @foreach($asientos as $fila => $asientosFila)
                                <div class="seat-row">
                                    <div class="seat-row-number">{{ $fila }}</div>
                                    @foreach(['A', 'B', 'C', 'D', 'E', 'F'] as $column)
                                        @php
                                            $asiento = $asientosFila->firstWhere('columna', $column);
                                            $clase = 'seat-btn ';
                                            $disabled = false;
                                            
                                            if ($asiento) {
                                                if ($asiento->estado == 'ocupado') {
                                                    $clase .= 'seat-ocupado';
                                                    $disabled = true;
                                                } elseif ($asiento->tipo_asiento == 'extra') {
                                                    $clase .= 'seat-extra';
                                                } elseif ($asiento->tipo_asiento == 'emergencia') {
                                                    $clase .= 'seat-emergencia';
                                                } else {
                                                    $clase .= 'seat-disponible';
                                                }
                                            } else {
                                                $clase .= 'seat-unavailable';
                                                $disabled = true;
                                            }
                                        @endphp
                                        
                                        <button 
                                            type="button" 
                                            class="{{ $clase }}" 
                                            data-seat-id="{{ $asiento ? $asiento->id_asiento : '' }}"
                                            data-seat-number="{{ $fila }}{{ $column }}"
                                            data-seat-type="{{ $asiento ? $asiento->tipo_asiento : '' }}"
                                            data-seat-price="{{ $asiento ? $asiento->precio_adicional : 0 }}"
                                            {{ $disabled ? 'disabled' : '' }}>
                                            <i class="bi {{ $disabled ? 'bi-x' : 'bi-circle' }}"></i>
                                        </button>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botón Continuar -->
                    <div class="text-center mt-4">
                        <button class="btn btn-primary btn-lg" id="btn-continuar">
                            Continuar al Pago <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Lateral: Resumen de Selección -->
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-card-checklist"></i> Resumen de Selección</h6>
                </div>
                <div class="card-body">
                    <!-- Información del Vuelo -->
                    <div class="mb-3">
                        <h6 class="fw-bold">Detalles del Vuelo</h6>
                        <div class="small text-muted">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Origen:</span>
                                <strong>{{ $vuelo->origen->nombre_lugar }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Destino:</span>
                                <strong>{{ $vuelo->destino->nombre_lugar }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Fecha:</span>
                                <strong>{{ date('d/m/Y', strtotime($vuelo->fecha_vuelo)) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Hora:</span>
                                <strong>{{ date('H:i', strtotime($vuelo->hora)) }}</strong>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Progreso -->
                    <div class="mb-3">
                        <strong>Progreso</strong>
                        <div class="progress mt-2" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%;" id="progress-bar">
                                <span id="progress-text">0 / {{ $cantidadPasajeros }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Asientos Seleccionados -->
                    <div class="mb-3">
                        <strong>Asientos seleccionados:</strong>
                        <div id="selected-seats-list" class="mt-2">
                            <p class="text-muted small mb-0">Ninguno</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Desglose de Precio -->
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Precio base:</span>
                            <span id="precio-base">${{ number_format($vuelo->precio->precio_ida ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Extras de asientos:</span>
                            <span id="precio-extras">$0</span>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total a Pagar:</strong>
                        <strong class="text-primary fs-4" id="total-price">${{ number_format($vuelo->precio->precio_ida ?? 0, 0, ',', '.') }}</strong>
                    </div>

                    <div class="alert alert-warning mt-3" id="warning-message" style="display: none;">
                        <i class="bi bi-exclamation-triangle"></i>
                        <small id="warning-text">Selecciona 1 asiento más</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para enviar datos -->
<form id="form-asientos" action="{{ route('reservas.asientos.guardar', $vuelo->id_vuelo) }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="asientos" id="input-asientos">
</form>

@endsection

@push('styles')
<style>
    .seat-map {
        background-color: #f8f9fa;
        padding: 30px 20px;
        border-radius: 10px;
        overflow-x: auto;
    }

    .seat-grid {
        display: inline-block;
        min-width: 100%;
    }

    .seat-header, .seat-row {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
    }

    .seat-row-number, .seat-column-label {
        width: 40px;
        text-align: center;
        font-weight: bold;
        color: #6c757d;
        font-size: 14px;
    }

    .seat-btn {
        width: 40px;
        height: 40px;
        margin: 0 4px;
        border: 2px solid transparent;
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 20px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .seat-btn:hover:not(:disabled) {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .seat-disponible {
        color: #198754;
        border-color: #198754;
    }

    .seat-disponible:hover {
        background-color: #d1e7dd;
    }

    .seat-extra {
        color: #ffc107;
        border-color: #ffc107;
    }

    .seat-extra:hover {
        background-color: #fff3cd;
    }

    .seat-emergencia {
        color: #0dcaf0;
        border-color: #0dcaf0;
    }

    .seat-emergencia:hover {
        background-color: #cff4fc;
    }

    .seat-ocupado {
        color: #6c757d;
        background-color: #e9ecef;
        border-color: #6c757d;
        cursor: not-allowed;
    }

    .seat-unavailable {
        color: #dee2e6;
        cursor: not-allowed;
        border: none;
    }

    .seat-seleccionado {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
    }

    /* Badges para la leyenda */
    .badge-seat {
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 2px solid;
    }

    .badge-seat-disponible {
        background-color: white;
        border-color: #198754;
    }

    .badge-seat-seleccionado {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .badge-seat-ocupado {
        background-color: #e9ecef;
        border-color: #6c757d;
    }

    .badge-seat-extra {
        background-color: white;
        border-color: #ffc107;
    }

    .badge-seat-emergencia {
        background-color: white;
        border-color: #0dcaf0;
    }

    .sticky-top {
        position: sticky;
    }

    @media (max-width: 991px) {
        .sticky-top {
            position: relative;
            margin-top: 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const maxPasajeros = {{ $cantidadPasajeros }};
    const precioBase = {{ $vuelo->precio->precio_ida ?? 0 }};
    let asientosSeleccionados = [];

    document.addEventListener('DOMContentLoaded', function() {
        const seatButtons = document.querySelectorAll('.seat-btn:not(:disabled)');
        
        seatButtons.forEach(button => {
            button.addEventListener('click', function() {
                const seatId = this.dataset.seatId;
                const seatNumber = this.dataset.seatNumber;
                const seatPrice = parseFloat(this.dataset.seatPrice);
                
                if (this.classList.contains('seat-seleccionado')) {
                    // Deseleccionar
                    this.classList.remove('seat-seleccionado');
                    this.querySelector('i').className = 'bi bi-circle';
                    asientosSeleccionados = asientosSeleccionados.filter(s => s.id !== seatId);
                } else {
                    // Seleccionar
                    if (asientosSeleccionados.length < maxPasajeros) {
                        this.classList.add('seat-seleccionado');
                        this.querySelector('i').className = 'bi bi-check-circle-fill';
                        asientosSeleccionados.push({
                            id: seatId,
                            number: seatNumber,
                            price: seatPrice
                        });
                    } else {
                        alert('Ya has seleccionado el máximo de asientos permitidos.');
                    }
                }
                
                actualizarResumen();
            });
        });

        document.getElementById('btn-continuar').addEventListener('click', function() {
            if (asientosSeleccionados.length === maxPasajeros) {
                // Mostrar loading
                this.innerHTML = '<i class="bi bi-hourglass-split"></i> Procesando...';
                this.disabled = true;
                
                document.getElementById('input-asientos').value = JSON.stringify(asientosSeleccionados.map(s => s.id));
                document.getElementById('form-asientos').submit();
            } else {
                // Mostrar mensaje de error más elegante
                const warningMessage = document.getElementById('warning-message');
                const warningText = document.getElementById('warning-text');
                warningText.textContent = `Selecciona ${maxPasajeros - asientosSeleccionados.length} asiento(s) más`;
                warningMessage.style.display = 'block';
                
                // Ocultar mensaje después de 3 segundos
                setTimeout(() => {
                    warningMessage.style.display = 'none';
                }, 3000);
            }
        });
    });
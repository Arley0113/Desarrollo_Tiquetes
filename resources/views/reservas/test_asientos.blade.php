@extends('layouts.app')

@section('title', 'Test Selección de Asientos')

@section('content')
<div class="container-fluid py-4">
    <div class="container">
        <h2>Test de Selección de Asientos</h2>
        
        <div class="row">
            <div class="col-md-8">
                <div class="seat-map">
                    <div class="seat-row">
                        <div class="seat-container">
                            <button type="button" class="seat-btn disponible" data-asiento-id="1" data-fila="1" data-columna="A" data-tipo="normal" data-precio="0">
                                1A
                            </button>
                        </div>
                        <div class="seat-container">
                            <button type="button" class="seat-btn disponible" data-asiento-id="2" data-fila="1" data-columna="B" data-tipo="normal" data-precio="0">
                                1B
                            </button>
                        </div>
                        <div class="seat-container">
                            <button type="button" class="seat-btn disponible" data-asiento-id="3" data-fila="1" data-columna="C" data-tipo="normal" data-precio="0">
                                1C
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Resumen</h5>
                        <p id="asientos-seleccionados">Ninguno</p>
                        <p id="precio-total">$0</p>
                        <button id="btn-continuar" class="btn btn-primary" disabled>Continuar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.seat-container {
    width: 40px;
    height: 40px;
    display: inline-block;
    margin: 2px;
}

.seat-btn {
    width: 100%;
    height: 100%;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.seat-btn.disponible {
    border-color: #dee2e6;
    background: white;
}

.seat-btn.seleccionado {
    background: #6f42c1;
    border-color: #6f42c1;
    color: white;
}

.seat-btn:hover {
    transform: scale(1.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Test iniciado');
    
    const asientosSeleccionados = [];
    const asientosContainer = document.getElementById('asientos-seleccionados');
    const precioTotal = document.getElementById('precio-total');
    const btnContinuar = document.getElementById('btn-continuar');
    
    document.querySelectorAll('.seat-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            console.log('Asiento clickeado:', this.dataset.asientoId);
            
            if (this.classList.contains('seleccionado')) {
                // Deseleccionar
                this.classList.remove('seleccionado');
                this.classList.add('disponible');
                
                const index = asientosSeleccionados.findIndex(a => a.id === this.dataset.asientoId);
                if (index > -1) {
                    asientosSeleccionados.splice(index, 1);
                }
            } else {
                // Seleccionar
                this.classList.remove('disponible');
                this.classList.add('seleccionado');
                
                asientosSeleccionados.push({
                    id: this.dataset.asientoId,
                    fila: this.dataset.fila,
                    columna: this.dataset.columna
                });
            }
            
            // Actualizar interfaz
            if (asientosSeleccionados.length === 0) {
                asientosContainer.textContent = 'Ninguno';
                btnContinuar.disabled = true;
            } else {
                asientosContainer.textContent = asientosSeleccionados.map(a => a.fila + a.columna).join(', ');
                btnContinuar.disabled = false;
            }
            
            console.log('Asientos seleccionados:', asientosSeleccionados);
        });
    });
});
</script>
@endsection

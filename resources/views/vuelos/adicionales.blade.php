@extends('layouts.app')

@section('title', 'Extras y Servicios Adicionales')

@section('content')
<div class="container my-5">
    <h3 class="fw-bold mb-4">Extras y Servicios Adicionales</h3>
    <p>Personaliza tu experiencia de vuelo</p>

    <form action="{{ route('resumen') }}" method="POST">
        @csrf

        {{-- Equipaje --}}
        <div class="card mb-4 p-3">
            <h5><i class="bi bi-bag"></i> Equipaje</h5>
            <p>Selecciona tu opción de equipaje</p>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="equipaje" id="mano" value="mano" checked>
                <label class="form-check-label" for="mano">Solo Equipaje de Mano (1 pieza de 10kg) - Gratis</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="equipaje" id="facturada1" value="facturada1">
                <label class="form-check-label" for="facturada1">1 Maleta Facturada 23kg - $45</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="equipaje" id="facturada2" value="facturada2">
                <label class="form-check-label" for="facturada2">2 Maletas Facturadas 23kg cada una - $80</label>
            </div>
        </div>

        {{-- Comidas --}}
        <div class="card mb-4 p-3">
            <h5><i class="bi bi-cup"></i> Comidas</h5>
            <p>Elige tu opción de comida</p>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="comida" id="sinComida" value="sinComida" checked>
                <label class="form-check-label" for="sinComida">Sin Comida - Gratis</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="comida" id="snack" value="snack">
                <label class="form-check-label" for="snack">Snack - $12</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="comida" id="estandar" value="estandar">
                <label class="form-check-label" for="estandar">Comida Estándar (Plato principal + bebida) - $25</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="comida" id="premium" value="premium">
                <label class="form-check-label" for="premium">Comida Premium (Menú gourmet + bebida premium) - $45</label>
            </div>
        </div>

        {{-- Servicios Adicionales --}}
        <div class="card mb-4 p-3">
            <h5><i class="bi bi-wifi"></i> Servicios Adicionales</h5>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="wifi" id="wifi" value="1">
                <label class="form-check-label" for="wifi">WiFi a Bordo (Conexión ilimitada durante el vuelo) - $1</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="seguro" id="seguro" value="1">
                <label class="form-check-label" for="seguro">Seguro de Viaje (Cobertura completa de cancelación y equipaje) - $3</label>
            </div>
        </div>

        {{-- Total --}}
        <div class="mb-4 p-3 bg-light border rounded">
            <h5>Total de Extras: <span id="totalExtras">$0</span></h5>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('paso.anterior') }}" class="btn btn-secondary">&laquo; Anterior</a>
            <button type="submit" class="btn btn-primary">Continuar &raquo;</button>
        </div>
    </form>
</div>

{{-- Opcional: Script para actualizar total --}}
<script>
    const precios = {
        'mano': 0,
        'facturada1': 45,
        'facturada2': 80,
        'sinComida': 0,
        'snack': 12,
        'estandar': 25,
        'premium': 45,
        'wifi': 1,
        'seguro': 3
    };

    const totalExtras = document.getElementById('totalExtras');
    const inputs = document.querySelectorAll('input');

    function actualizarTotal() {
        let total = 0;
        inputs.forEach(input => {
            if ((input.type === 'radio' && input.checked) || (input.type === 'checkbox' && input.checked)) {
                total += precios[input.value];
            }
        });
        totalExtras.textContent = `$${total}`;
    }

    inputs.forEach(input => input.addEventListener('change', actualizarTotal));
    actualizarTotal();
</script>
@endsection

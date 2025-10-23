@extends('layouts.app')

@section('title', 'Completa tu Reserva')

@section('content')
<div class="container-fluid py-4">
  <div class="container">
    <!-- Progreso -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card shadow-sm border-0">
          <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
              <span class="badge bg-success">Pago 100% Seguro</span>
              <span class="text-muted">Tu compra está protegida con encriptación SSL</span>
            </div>
            <div class="fw-semibold">Reserva #{{ $reserva->id_reserva }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Método de Pago -->
      <div class="col-lg-8">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white border-0">
            <h5 class="mb-0">
              <i class="bi bi-credit-card me-2"></i>
              Completa tu Reserva
            </h5>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('pagos.store', $reserva->id_reserva) }}" id="pagoForm">
              @csrf
              <!-- Datos ocultos -->
              <input type="hidden" name="monto" value="{{ session('precio_total') ?? (data_get($reserva, 'vuelo.precio.precio_ida', 0)) }}">

              <!-- Método de pago -->
              <div class="mb-4">
                <label class="form-label fw-semibold">Método de Pago</label>
                <div class="list-group">
                  <label class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                      <i class="bi bi-credit-card-2-front text-primary"></i>
                      <div>
                        <div class="fw-semibold">Tarjeta de crédito</div>
                        <small class="text-muted">Visa, MasterCard</small>
                      </div>
                    </div>
                    <input class="form-check-input" type="radio" name="medio_pago" value="Tarjeta de crédito" checked>
                  </label>
                  <label class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                      <i class="bi bi-credit-card text-primary"></i>
                      <div>
                        <div class="fw-semibold">Tarjeta débito</div>
                        <small class="text-muted">Débito directo</small>
                      </div>
                    </div>
                    <input class="form-check-input" type="radio" name="medio_pago" value="Tarjeta débito">
                  </label>
                  <label class="list-group-item d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                      <i class="bi bi-bank text-primary"></i>
                      <div>
                        <div class="fw-semibold">PSE</div>
                        <small class="text-muted">Pago seguro en línea</small>
                      </div>
                    </div>
                    <input class="form-check-input" type="radio" name="medio_pago" value="PSE">
                  </label>
                </div>
              </div>

              <!-- Detalles de pago -->
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nombre del titular *</label>
                  <input type="text" name="nombre_titular" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Tipo de documento *</label>
                  <select name="tipo_documento" class="form-select" required>
                    <option value="CC">Cédula</option>
                    <option value="CE">C.E.</option>
                    <option value="PP">Pasaporte</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Documento *</label>
                  <input type="text" name="documento" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Correo *</label>
                  <input type="email" name="correo" class="form-control" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Teléfono *</label>
                  <input type="text" name="telefono" class="form-control" required>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('reservas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary btn-lg">
                  <i class="bi bi-check2-circle me-1"></i> Confirmar Pago
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Resumen de pedido -->
      <div class="col-lg-4">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h6 class="fw-bold mb-3">Resumen del Pedido</h6>
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted">Subtotal</span>
              <span>${{ number_format(session('precio_total') ?? (data_get($reserva, 'vuelo.precio.precio_ida', 0)), 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span class="text-muted">Impuestos (0%)</span>
              <span>$0</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
              <span class="fw-semibold">Total</span>
              <span class="fw-bold text-primary h5 mb-0">${{ number_format(session('precio_total') ?? (data_get($reserva, 'vuelo.precio.precio_ida', 0)), 0, ',', '.') }}</span>
            </div>
            <div class="alert alert-success d-flex align-items-center" role="alert">
              <i class="bi bi-shield-lock me-2"></i>
              <div>Garantía de Mejor Precio y Transacción Segura</div>
            </div>
          </div>
        </div>

        <!-- Datos del vuelo -->
        <div class="card shadow-sm border-0 mt-3">
          <div class="card-body">
            <h6 class="fw-bold mb-3">Vuelo</h6>
            @php($vuelo = $reserva->vuelo)
            @if($vuelo)
            <div class="d-flex justify-content-between">
              <div>
                <div class="fw-semibold">{{ optional($vuelo->origen)->nombre_lugar }} → {{ optional($vuelo->destino)->nombre_lugar }}</div>
                <small class="text-muted">
                  {{ optional(\Carbon\Carbon::parse($vuelo->fecha_vuelo))->format('d/m/Y') }} ·
                  {{ optional(\Carbon\Carbon::parse($vuelo->hora))->format('H:i') }}
                </small>
              </div>
              <div class="text-end">
                <div class="fw-semibold">${{ number_format(data_get($vuelo, 'precio.precio_ida', 0), 0, ',', '.') }}</div>
                <small class="text-muted">Precio base</small>
              </div>
            </div>
            @else
              <div class="alert alert-warning mb-0" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Esta reserva no tiene un vuelo asociado. Continúa con el pago o regresa.
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
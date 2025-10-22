<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle de Vuelos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/detalle-vuelos.css') }}">
</head>
<body>
  <div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold">Bogota→ Pereira</h4>
      <span class="badge bg-success">5 vuelos disponibles</span>
    </div>

    <div class="row">
      <div class="col-md-3">
        <div class="card shadow-sm p-3 mb-4">
          <h6 class="fw-bold mb-3">Rango de Precio</h6>
          <input type="range" class="form-range" min="200" max="500" id="rangoPrecio">
          <div class="d-flex justify-content-between">
            <span>$200.000</span>
            <span>$500.000</span>
          </div>

          <hr>
          <h6 class="fw-bold mb-3">Comodidades</h6>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="wifi">
            <label class="form-check-label" for="wifi">WiFi disponible</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="reembolsable">
            <label class="form-check-label" for="reembolsable">Reembolsable</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="directo">
            <label class="form-check-label" for="directo">Solo vuelos directos</label>
          </div>

          <button class="btn btn-outline-secondary w-100 mt-3" id="limpiarFiltros">Limpiar Filtros</button>
        </div>
      </div>

      <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <span class="fw-bold text-secondary">Precio más bajo:</span>
            <span class="text-success fw-bold">$290.000</span>
          </div>
          <div>
            <span class="fw-bold text-secondary me-2">Duración promedio:</span> <span>5h 30m</span> |
            <span class="fw-bold text-secondary ms-2 me-2">Mejor valorado:</span> <span>⭐ 4.8</span>
          </div>
        </div>

        
        <div id="lista-vuelos">

          <div class="card vuelo shadow-sm p-3 mb-3" data-precio="350" data-directo="true" data-wifi="true" data-reembolsable="true">
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <div class="icono me-3"><i class="bi bi-airplane"></i></div>
                <div>
                  <h6 class="fw-bold mb-1">American Airlines</h6>
                  <small class="text-muted">AA1234</small>
                </div>
              </div>
              <div class="text-center">
                <h6 class="fw-bold">08:00</h6>
                <small class="text-muted">Bogota</small>
              </div>
              <div class="text-center">
                <small class="text-muted">5h 30m</small>
              </div>
              <div class="text-center">
                <h6 class="fw-bold">11:30</h6>
                <small class="text-muted">LAX</small>
              </div>
              <div class="text-end">
                <h5 class="fw-bold text-primary">$350.000</h5>
                <button class="btn btn-outline-primary btn-sm seleccionar-vuelo">Seleccionar</button>
              </div>
            </div>
          </div>

          <div class="card vuelo shadow-sm p-3 mb-3" data-precio="290" data-directo="true" data-wifi="true" data-reembolsable="false">
            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex align-items-center">
                <div class="icono me-3"><i class="bi bi-airplane"></i></div>
                <div>
                  <h6 class="fw-bold mb-1">Southwest Airlines</h6>
                  <small class="text-muted">SW456</small>
                </div>
              </div>
              <div class="text-center">
                <h6 class="fw-bold">10:00</h6>
                <small class="text-muted">Bogota</small>
              </div>
              <div class="text-center">
                <small class="text-muted">5h 30m</small>
              </div>
              <div class="text-center">
                <h6 class="fw-bold">13:30</h6>
                <small class="text-muted">LAX</small>
              </div>
              <div class="text-end">
                <h5 class="fw-bold text-primary">$290.000</h5>
                <button class="btn btn-outline-primary btn-sm seleccionar-vuelo">Seleccionar</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div id="vuelo-seleccionado" class="d-flex justify-content-between align-items-center p-3 mt-4 shadow-sm bg-white rounded">
      <div>
        <strong>Vuelo seleccionado:</strong> <span id="nombre-vuelo">Ninguno</span>
      </div>
      <div>
        <strong>Total:</strong> <span id="precio-vuelo">$0</span>
        <button class="btn btn-primary ms-3" disabled id="continuar">Continuar</button>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.js"></script>
  <script>
    
    const botones = document.querySelectorAll('.seleccionar-vuelo');
    const nombreVuelo = document.getElementById('nombre-vuelo');
    const precioVuelo = document.getElementById('precio-vuelo');
    const continuarBtn = document.getElementById('continuar');

    botones.forEach(boton => {
      boton.addEventListener('click', () => {
        const card = boton.closest('.vuelo');
        nombreVuelo.textContent = card.querySelector('h6').textContent;
        precioVuelo.textContent = card.querySelector('h5').textContent;
        continuarBtn.disabled = false;
      });
    });

    document.getElementById('limpiarFiltros').addEventListener('click', () => {
      document.querySelectorAll('.form-check-input').forEach(c => c.checked = false);
      document.getElementById('rangoPrecio').value = 500;
    });
  </script>
</body>
</html>

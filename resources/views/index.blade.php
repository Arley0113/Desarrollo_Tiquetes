@extends('layouts.app')

@section('title', 'Inicio | VuelosYa')

@push('styles')
<style>
/* Reset and Base Styles */
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #333; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

/* Hero Section */
.hero-section { min-height: 100vh; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #8e44ad 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
.hero-content { text-align: center; z-index: 2; max-width: 1000px; padding: 0 20px; }
.hero-title { font-size: 4rem; font-weight: 800; color: white; margin-bottom: 1.5rem; line-height: 1.2; }
.hero-subtitle { font-size: 1.25rem; color: rgba(255, 255, 255, 0.9); margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto; }

/* Search Container */
.search-container { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 20px; padding: 2rem; margin-bottom: 3rem; }

/* Trip Type Selection */
.trip-type-container { margin-bottom: 1.5rem; }
.trip-type-options { display: flex; gap: 2rem; justify-content: center; }
.trip-type-option { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: white; font-weight: 500; }
.trip-type-option input[type="radio"] { width: 18px; height: 18px; accent-color: #667eea; }
.trip-type-label { font-size: 1rem; }

.search-inputs { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 1rem; margin-bottom: 2rem; }
.search-inputs.with-return { grid-template-columns: 1fr 1fr 1fr 1fr auto; }
.input-group { position: relative; display: flex; align-items: center; }
.input-icon { position: absolute; left: 1rem; color: rgba(255, 255, 255, 0.7); font-size: 1.1rem; z-index: 1; }
.form-input { width: 100%; padding: 1rem 1rem 1rem 3rem; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; color: white; font-size: 1rem; transition: all 0.3s ease; }
.form-input::placeholder { color: rgba(255, 255, 255, 0.7); }
.form-input:focus { outline: none; background: rgba(255, 255, 255, 0.15); border-color: rgba(255, 255, 255, 0.4); }
.form-input option { background: #2d3748; color: white; padding: 0.5rem; }
.form-input:focus option { background: #1a202c; color: white; }
.search-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 12px; padding: 1rem 2rem; color: white; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem; }
.search-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); }

/* Statistics */
.stats-container { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; text-align: center; }
.stat-item { color: white; }
.stat-number { font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; }
.stat-label { font-size: 1rem; opacity: 0.9; }

/* Scroll Indicator */
.scroll-indicator { position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); color: white; font-size: 1.5rem; animation: bounce 2s infinite; }
@keyframes bounce { 0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); } 40% { transform: translateX(-50%) translateY(-10px); } 60% { transform: translateX(-50%) translateY(-5px); } }

/* Features Section */
.features-section { padding: 5rem 0; background: white; }
.section-header { text-align: center; margin-bottom: 4rem; }
.section-title { font-size: 2.5rem; font-weight: 700; color: #2d3748; margin-bottom: 1rem; }
.section-subtitle { font-size: 1.1rem; color: #718096; max-width: 600px; margin: 0 auto; }
.features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; }
.feature-card { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; }
.feature-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12); }
.feature-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; font-size: 1.5rem; }
.feature-icon.purple { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.feature-icon.blue { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.feature-icon.green { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
.feature-icon.orange { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
.feature-title { font-size: 1.25rem; font-weight: 600; color: #2d3748; margin-bottom: 1rem; }
.feature-description { color: #718096; line-height: 1.6; }

/* Destinations Section */
.destinations-section { padding: 5rem 0; background: #f7fafc; }
.destinations-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; }
.destination-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; position: relative; }
.destination-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12); }
.offer-tag { position: absolute; top: 1rem; right: 1rem; background: #e53e3e; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600; z-index: 1; }
.destination-image { height: 200px; overflow: hidden; }
.destination-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
.destination-card:hover .destination-image img { transform: scale(1.05); }
.destination-info { padding: 1.5rem; }
.destination-name { font-size: 1.25rem; font-weight: 600; color: #2d3748; margin-bottom: 0.5rem; }
.destination-country { color: #718096; margin-bottom: 1rem; }
.destination-price { display: flex; align-items: baseline; margin-bottom: 1rem; }
.price-symbol { font-size: 1rem; color: #4a5568; margin-right: 0.25rem; }
.price-amount { font-size: 2rem; font-weight: 700; color: #2d3748; }
.price-decimal { font-size: 1rem; color: #4a5568; }
.destination-btn { width: 100%; background: #2d3748; color: white; border: none; padding: 0.75rem 1rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
.destination-btn:hover { background: #1a202c; transform: translateY(-2px); }

/* CTA Section */
.cta-section { padding: 5rem 0; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #8e44ad 100%); text-align: center; }
.cta-content { max-width: 600px; margin: 0 auto; }
.cta-title { font-size: 2.5rem; font-weight: 700; color: white; margin-bottom: 1rem; }
.cta-subtitle { font-size: 1.1rem; color: rgba(255, 255, 255, 0.9); margin-bottom: 2rem; }
.cta-btn { display: inline-flex; align-items: center; gap: 0.5rem; background: white; color: #2d3748; padding: 1rem 2rem; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease; }
.cta-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); color: #2d3748; text-decoration: none; }

/* Responsive */
@media (max-width: 768px) {
  .hero-title { font-size: 2.5rem; }
  .hero-subtitle { font-size: 1rem; }
  .search-inputs { grid-template-columns: 1fr; }
  .stats-container { grid-template-columns: 1fr; gap: 1rem; }
  .section-title { font-size: 2rem; }
  .features-grid { grid-template-columns: 1fr; }
  .destinations-grid { grid-template-columns: 1fr; }
  .cta-title { font-size: 2rem; }
}
@media (max-width: 480px) {
  .search-container { padding: 1.5rem; }
  .hero-title { font-size: 2rem; }
  .feature-card, .destination-info { padding: 1rem; }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
  <div class="hero-content">
    <div class="hero-text">
      <h1 class="hero-title">Vuela a tus Sueños</h1>
      <p class="hero-subtitle">Descubre el mundo con las mejores tarifas y una experiencia de reserva revolucionaria</p>
    </div>

    <!-- Search Form -->
    <div class="search-container">
      <form method="GET" action="{{ route('vuelos.buscar') }}" class="search-form">
        <!-- Trip Type Selection -->
        <div class="trip-type-container">
          <div class="trip-type-options">
            <label class="trip-type-option">
              <input type="radio" name="tipo_viaje" value="ida" checked>
              <span class="trip-type-label">Solo Ida</span>
            </label>
            <label class="trip-type-option">
              <input type="radio" name="tipo_viaje" value="ida_regreso">
              <span class="trip-type-label">Ida y Regreso</span>
            </label>
          </div>
        </div>

        <div class="search-inputs">
          <div class="input-group">
            <i class="bi bi-airplane input-icon"></i>
            <select name="origen" class="form-input" required>
              <option value="">¿De dónde partes?</option>
              @foreach($lugares as $lugar)
                <option value="{{ is_array($lugar) ? $lugar['id_lugar'] : $lugar->id_lugar }}">
                  {{ is_array($lugar) ? $lugar['nombre_lugar'] : $lugar->nombre_lugar }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="input-group">
            <i class="bi bi-geo-alt input-icon"></i>
            <select name="destino" class="form-input" required>
              <option value="">¿A dónde viajas?</option>
              @foreach($lugares as $lugar)
                <option value="{{ is_array($lugar) ? $lugar['id_lugar'] : $lugar->id_lugar }}">
                  {{ is_array($lugar) ? $lugar['nombre_lugar'] : $lugar->nombre_lugar }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="input-group">
            <i class="bi bi-calendar input-icon"></i>
            <input type="date" name="fecha" class="form-input" required min="{{ date('Y-m-d') }}" placeholder="Fecha de ida">
          </div>

          <div class="input-group" id="fecha-regreso-group" style="display: none;">
            <i class="bi bi-calendar-check input-icon"></i>
            <input type="date" name="fecha_regreso" class="form-input" min="{{ date('Y-m-d') }}" placeholder="Fecha de regreso">
          </div>

          <button type="submit" class="search-btn">
            <i class="bi bi-search"></i>
            Buscar Vuelos
          </button>
        </div>

        <!-- Statistics -->
        <div class="stats-container">
          <div class="stat-item">
            <div class="stat-number">500+</div>
            <div class="stat-label">Vuelos Diarios</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">150+</div>
            <div class="stat-label">Destinos</div>
          </div>
          <div class="stat-item">
            <div class="stat-number">1M+</div>
            <div class="stat-label">Clientes Felices</div>
          </div>
        </div>
      </form>
    </div>

    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
      <i class="bi bi-chevron-down"></i>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="features-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Volamos Más Allá de tus Expectativas</h2>
      <p class="section-subtitle">Tecnología de punta al servicio de tu comodidad</p>
    </div>

    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon purple"><i class="bi bi-hash"></i></div>
        <h3 class="feature-title">Experiencia Premium</h3>
        <p class="feature-description">Vuelos rápidos y modernos para reservar sin complicaciones.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon blue"><i class="bi bi-shield-check"></i></div>
        <h3 class="feature-title">100% Seguro</h3>
        <p class="feature-description">Tus datos y pagos protegidos con encriptación de nivel bancario.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon green"><i class="bi bi-graph-up"></i></div>
        <h3 class="feature-title">Mejores Precios</h3>
        <p class="feature-description">Algoritmo inteligente que encuentra las mejores ofertas.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon orange"><i class="bi bi-lightbulb"></i></div>
        <h3 class="feature-title">Soporte 24/7</h3>
        <p class="feature-description">Atención inmediata en cualquier momento del día.</p>
      </div>
    </div>
  </div>
</section>

<!-- Destinations Section -->
<section class="destinations-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Explora el Mundo</h2>
    </div>

    <div class="destinations-grid">
      @php
        $destinos = [
          ['nombre' => 'Nueva York', 'pais' => 'Estados Unidos', 'precio' => '280', 'oferta' => true, 'img' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=400'],
          ['nombre' => 'Los Angeles', 'pais' => 'Estados Unidos', 'precio' => '420', 'oferta' => false, 'img' => 'https://images.unsplash.com/photo-1515894206792-767504b7869f?w=400'],
          ['nombre' => 'Miami', 'pais' => 'Estados Unidos', 'precio' => '280', 'oferta' => false, 'img' => 'https://images.unsplash.com/photo-1514214246283-d427a95c5d2f?w=400'],
          ['nombre' => 'San Francisco', 'pais' => 'Estados Unidos', 'precio' => '395', 'oferta' => false, 'img' => 'https://images.unsplash.com/photo-1501594907352-04cda38ebc29?w=400'],
        ];
      @endphp

      @foreach ($destinos as $destino)
        <div class="destination-card">
          @if($destino['oferta'])
            <div class="offer-tag">Oferta</div>
          @endif
          <div class="destination-image">
            <img src="{{ $destino['img'] }}" alt="{{ $destino['nombre'] }}">
          </div>
          <div class="destination-info">
            <h3 class="destination-name">{{ $destino['nombre'] }}</h3>
            <p class="destination-country">{{ $destino['pais'] }}</p>
            <div class="destination-price">
              <span class="price-symbol">$</span>
              <span class="price-amount">{{ $destino['precio'] }}</span>
              <span class="price-decimal">00</span>
            </div>
            <button class="destination-btn">Ver Vuelos <i class="bi bi-plus"></i></button>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section">
  <div class="container">
    <div class="cta-content">
      <h2 class="cta-title">¿Listo para tu Próxima Aventura?</h2>
      <p class="cta-subtitle">Únete a millones de viajeros que confían en nosotros.</p>
      <a href="{{ route('register.form') }}" class="cta-btn">
        <i class="bi bi-airplane"></i>
        Comenzar Ahora
      </a>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Elementos del formulario
  const radioIda = document.querySelector('input[name="tipo_viaje"][value="ida"]');
  const radioIdaRegreso = document.querySelector('input[name="tipo_viaje"][value="ida_regreso"]');
  const fechaRegresoGroup = document.getElementById('fecha-regreso-group');
  const fechaRegresoInput = document.querySelector('input[name="fecha_regreso"]');
  const searchInputs = document.querySelector('.search-inputs');
  const fechaIdaInput = document.querySelector('input[name="fecha"]');

  // Función para mostrar/ocultar fecha de regreso
  function toggleFechaRegreso() {
    if (radioIdaRegreso.checked) {
      fechaRegresoGroup.style.display = 'block';
      searchInputs.classList.add('with-return');
      fechaRegresoInput.required = true;
    } else {
      fechaRegresoGroup.style.display = 'none';
      searchInputs.classList.remove('with-return');
      fechaRegresoInput.required = false;
      fechaRegresoInput.value = '';
    }
  }

  // Event listeners para los radio buttons
  radioIda.addEventListener('change', toggleFechaRegreso);
  radioIdaRegreso.addEventListener('change', toggleFechaRegreso);

  // Validar que fecha de regreso sea posterior a fecha de ida
  fechaIdaInput.addEventListener('change', function() {
    if (fechaRegresoInput.value && fechaRegresoInput.value <= this.value) {
      fechaRegresoInput.value = '';
    }
    fechaRegresoInput.min = this.value;
  });

  fechaRegresoInput.addEventListener('change', function() {
    if (this.value && fechaIdaInput.value && this.value <= fechaIdaInput.value) {
      alert('La fecha de regreso debe ser posterior a la fecha de ida');
      this.value = '';
    }
  });

  // Establecer fecha de hoy por defecto para fecha de ida
  if (fechaIdaInput && !fechaIdaInput.value) {
    const hoy = new Date();
    const fechaHoy = hoy.toISOString().split('T')[0];
    fechaIdaInput.value = fechaHoy;
  }

  // Inicializar estado
  toggleFechaRegreso();
});
</script>
@endpush
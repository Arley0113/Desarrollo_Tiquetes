@extends('layouts.app')

@section('title', 'Vuelos de ' . $origen->nombre_lugar . ' a ' . $destino->nombre_lugar)

@section('content')
<div class="flight-search-container">
    <!-- Header Section -->
    <div class="search-header">
        <div class="container">
            <div class="search-info">
                <div class="route-info">
                    <div class="airport-info">
                        <div class="airport-code">{{ substr($origen->nombre_lugar, 0, 3) }}</div>
                        <div class="airport-name">{{ $origen->nombre_lugar }}</div>
                    </div>
                    <div class="flight-path">
                        <i class="bi bi-airplane"></i>
                        <div class="flight-line"></div>
                    </div>
                    <div class="airport-info">
                        <div class="airport-code">{{ substr($destino->nombre_lugar, 0, 3) }}</div>
                        <div class="airport-name">{{ $destino->nombre_lugar }}</div>
    </div>
                </div>
                <div class="search-details">
                    <div class="date-info">
                        <i class="bi bi-calendar"></i>
                        <span>{{ date('d M Y', strtotime($request->fecha)) }}</span>
                </div>
                    <div class="results-count">
                        <span class="badge">
                            {{ $vuelosIda->count() }} vuelos de ida
                            @if($request->tipo_viaje === 'ida_regreso')
                                · {{ $vuelosRegreso->count() }} de regreso
                            @endif
                        </span>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="filters-sidebar">
                    <div class="filter-section">
                        <h5 class="filter-title">
                            <i class="bi bi-funnel"></i>
                            Filtros
                        </h5>

                        <!-- Modificar búsqueda: tipo de viaje -->
                        <form method="GET" action="{{ route('vuelos.buscar') }}" class="mb-4">
                            <input type="hidden" name="origen" value="{{ $request->origen }}">
                            <input type="hidden" name="destino" value="{{ $request->destino }}">
                            <input type="hidden" name="fecha" value="{{ $request->fecha }}">

                            <div class="filter-group">
                                <label class="filter-label">Tipo de viaje</label>
                                <div class="checkbox-group">
                                    <label class="checkbox-item">
                                        <input type="radio" name="tipo_viaje" value="ida" {{ ($request->tipo_viaje ?? 'ida') === 'ida' ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                        <span class="checkbox-text">Solo ida</span>
                                    </label>
                                    <label class="checkbox-item">
                                        <input type="radio" name="tipo_viaje" value="ida_regreso" {{ ($request->tipo_viaje ?? 'ida') === 'ida_regreso' ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                        <span class="checkbox-text">Ida y regreso</span>
                                    </label>
                                </div>
                            </div>

                            <div class="filter-group" id="grupo-fecha-regreso" style="{{ ($request->tipo_viaje ?? 'ida') === 'ida_regreso' ? '' : 'display:none;' }}">
                                <label class="filter-label">Fecha de regreso</label>
                                <input type="date" name="fecha_regreso" class="form-control" min="{{ $request->fecha }}" value="{{ $request->fecha_regreso }}">
                            </div>

                            <button type="submit" class="clear-filters-btn">
                                <i class="bi bi-arrow-repeat"></i>
                                Actualizar búsqueda
                            </button>
                        </form>
                        
                        <!-- Price Range -->
                        <div class="filter-group">
                            <label class="filter-label">Rango de Precio</label>
                            <div class="price-range-container">
                                <input type="range" class="price-range" min="0" max="{{ $precioMaximo }}" id="rangoPrecio" value="{{ $precioMaximo }}">
                                <div class="price-labels">
                                    <span class="price-min">$0</span>
                                    <span class="price-max">${{ number_format($precioMaximo, 0, ',', '.') }}</span>
                                </div>
                                <div class="current-price">
                                    <span class="price-display">Hasta ${{ number_format($precioMaximo, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Flight Type -->
                        <div class="filter-group">
                            <label class="filter-label">Tipo de Vuelo</label>
                            <div class="checkbox-group">
                                <label class="checkbox-item">
                                    <input type="checkbox" id="vuelosDirectos" checked>
                                    <span class="checkmark"></span>
                                    <span class="checkbox-text">Solo vuelos directos</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" id="vuelosConEscala">
                                    <span class="checkmark"></span>
                                    <span class="checkbox-text">Vuelos con escala</span>
                                </label>
                            </div>
                        </div>

                        <!-- Amenities -->
                        <div class="filter-group">
                            <label class="filter-label">Comodidades</label>
                            <div class="checkbox-group">
                                <label class="checkbox-item">
                                    <input type="checkbox" id="wifi">
                                    <span class="checkmark"></span>
                                    <span class="checkbox-text">WiFi disponible</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" id="reembolsable">
                                    <span class="checkmark"></span>
                                    <span class="checkbox-text">Reembolsable</span>
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" id="asientosDisponibles">
                                    <span class="checkmark"></span>
                                    <span class="checkbox-text">Con asientos disponibles</span>
                                </label>
                            </div>
                        </div>

                        <!-- Sort Options -->
                        <div class="filter-group">
                            <label class="filter-label">Ordenar por</label>
                            <select class="sort-select" id="ordenarPor">
                                <option value="precio">Precio (menor a mayor)</option>
                                <option value="precio-desc">Precio (mayor a menor)</option>
                                <option value="hora">Hora de salida</option>
                                <option value="duracion">Duración</option>
                            </select>
                        </div>

                        <button class="clear-filters-btn" id="limpiarFiltros">
                            <i class="bi bi-arrow-clockwise"></i>
                            Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div>

            <!-- Results Section -->
            <div class="col-lg-9">
                <div class="results-section">
                    <!-- Results Header -->
                    <div class="results-header">
                        <div class="results-info">
                            <h4 class="results-title">
                                <i class="bi bi-list-ul"></i>
                                Resultados de búsqueda
                            </h4>
                            <div class="results-count">
                                <span id="contadorResultados">{{ $vuelosIda->count() }}</span> vuelos disponibles (ida)
                            </div>
                        </div>
                        <div class="view-options">
                            <button class="view-btn active" data-view="list">
                                <i class="bi bi-list"></i>
                            </button>
                            <button class="view-btn" data-view="grid">
                                <i class="bi bi-grid"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Flight Results -->
                    <div class="flights-container" id="lista-vuelos">
                        @if($vuelosIda->isEmpty())
                            <div class="no-results">
                                <div class="no-results-content">
                                    <i class="bi bi-search"></i>
                                    <h5>No se encontraron vuelos</h5>
                                    <p>No hay vuelos disponibles para la ruta {{ $origen->nombre_lugar }} → {{ $destino->nombre_lugar }} en la fecha seleccionada.</p>
                                    <div class="suggestions">
                                        <p><strong>Sugerencias:</strong></p>
                                        <ul>
                                            <li>Intenta con una fecha diferente</li>
                                            <li>Verifica que el origen y destino sean diferentes</li>
                                            <li>Busca vuelos en fechas cercanas</li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('inicio') }}" class="btn btn-primary">
                                        <i class="bi bi-arrow-left"></i>
                                        Nueva Búsqueda
                                    </a>
                                </div>
                            </div>
                        @else
                            @foreach ($vuelosIda as $vuelo)
                            <div class="flight-card" 
                                 data-precio="{{ $vuelo->precio->precio_ida ?? 0 }}" 
                                 data-directo="{{ $vuelo->directo ? 'true' : 'false' }}" 
                                 data-wifi="{{ $vuelo->wifi ? 'true' : 'false' }}" 
                                 data-reembolsable="{{ $vuelo->reembolsable ? 'true' : 'false' }}"
                                 data-hora="{{ $vuelo->hora }}"
                                 data-duracion="{{ $vuelo->duracion ?? '2h 30m' }}"
                                 data-asientos-disponibles="{{ $vuelo->asientosDisponibles() ?? 0 }}">
                                
                                <div class="flight-main">
                                    <!-- Airline Info -->
                                    <div class="airline-section">
                                        <div class="airline-logo">
                                            <i class="bi bi-airplane-fill"></i>
                                        </div>
                                        <div class="airline-info">
                                            <div class="airline-name">{{ $vuelo->avion->nombre ?? 'Aerolínea' }}</div>
                                            <div class="flight-code">{{ $vuelo->codigo_vuelo ?? 'XX0000' }}</div>
                                        </div>
                                    </div>

                                    <!-- Flight Times -->
                                    <div class="flight-times">
                                        <div class="time-section">
                                            <div class="time">{{ date('H:i', strtotime($vuelo->hora)) }}</div>
                                            <div class="airport">{{ $origen->nombre_lugar }}</div>
                                        </div>
                                        <div class="flight-duration">
                                            <div class="duration">{{ $vuelo->duracion ?? '2h 30m' }}</div>
                                            <div class="flight-path">
                                                @if($vuelo->directo)
                                                    <i class="bi bi-arrow-right text-success"></i>
                                                    <span class="direct-label">Directo</span>
                                                @else
                                                    <i class="bi bi-arrow-right text-warning"></i>
                                                    <span class="stop-label">Con escala</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="time-section">
                                            <div class="time">{{ date('H:i', strtotime($vuelo->hora_llegada ?? $vuelo->hora)) }}</div>
                                            <div class="airport">{{ $destino->nombre_lugar }}</div>
                                        </div>
                                    </div>

                                    <!-- Price and Action -->
                                    <div class="price-section">
                                        <div class="price-info">
                                            <div class="price">${{ number_format($vuelo->precio->precio_ida ?? 0, 0, ',', '.') }}</div>
                                            <div class="price-per">por persona</div>
                                            <div class="seats-available">{{ $vuelo->asientosDisponibles() ?? 0 }} asientos disponibles</div>
                                        </div>
                                        <a href="{{ route('vuelo.mostrar', $vuelo->id_vuelo) }}" class="select-btn">
                                            <i class="bi bi-arrow-right"></i>
                                            Seleccionar
                                        </a>
                                    </div>
                                </div>

                                <!-- Flight Features -->
                                <div class="flight-features">
                                    @if($vuelo->wifi)
                                        <span class="feature-badge wifi">
                                            <i class="bi bi-wifi"></i>
                                            WiFi
                                        </span>
                                    @endif
                                    @if($vuelo->reembolsable)
                                        <span class="feature-badge refundable">
                                            <i class="bi bi-arrow-clockwise"></i>
                                            Reembolsable
                                        </span>
                                    @endif
                                    @if($vuelo->directo)
                                        <span class="feature-badge direct">
                                            <i class="bi bi-arrow-right"></i>
                                            Directo
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>

                    @if(($request->tipo_viaje ?? 'ida') === 'ida_regreso')
                    <!-- Regreso Results Header -->
                    <div class="results-header mt-4">
                        <div class="results-info">
                            <h4 class="results-title">
                                <i class="bi bi-arrow-left-right"></i>
                                Vuelos de regreso ({{ $destino->nombre_lugar }} → {{ $origen->nombre_lugar }})
                            </h4>
                            <div class="results-count">
                                <span>{{ $vuelosRegreso->count() }}</span> vuelos disponibles (regreso) — 
                                <i class="bi bi-calendar"></i>
                                <span>{{ isset($request->fecha_regreso) ? date('d M Y', strtotime($request->fecha_regreso)) : 'Fecha no especificada' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Regreso Flight Results -->
                    <div class="flights-container" id="lista-vuelos-regreso">
                        @if($vuelosRegreso->isEmpty())
                            <div class="no-results">
                                <div class="no-results-content">
                                    <i class="bi bi-search"></i>
                                    <h5>No se encontraron vuelos de regreso</h5>
                                    <p>No hay vuelos disponibles para la ruta {{ $destino->nombre_lugar }} → {{ $origen->nombre_lugar }} en la fecha seleccionada.</p>
                                </div>
                            </div>
                        @else
                            @foreach ($vuelosRegreso as $vuelo)
                            <div class="flight-card" 
                                 data-precio="{{ $vuelo->precio->precio_ida ?? 0 }}" 
                                 data-directo="{{ $vuelo->directo ? 'true' : 'false' }}" 
                                 data-wifi="{{ $vuelo->wifi ? 'true' : 'false' }}" 
                                 data-reembolsable="{{ $vuelo->reembolsable ? 'true' : 'false' }}"
                                 data-hora="{{ $vuelo->hora }}"
                                 data-duracion="{{ $vuelo->duracion ?? '2h 30m' }}"
                                 data-asientos-disponibles="{{ $vuelo->asientosDisponibles() ?? 0 }}">
                                
                                <div class="flight-main">
                                    <div class="airline-section">
                                        <div class="airline-logo">
                                            <i class="bi bi-airplane-fill"></i>
                                        </div>
                                        <div class="airline-info">
                                            <div class="airline-name">{{ $vuelo->avion->nombre ?? 'Aerolínea' }}</div>
                                            <div class="flight-code">{{ $vuelo->codigo_vuelo ?? 'XX0000' }}</div>
                                        </div>
                                    </div>

                                    <div class="flight-times">
                                        <div class="time-section">
                                            <div class="time">{{ date('H:i', strtotime($vuelo->hora)) }}</div>
                                            <div class="airport">{{ $destino->nombre_lugar }}</div>
                                        </div>
                                        <div class="flight-duration">
                                            <div class="duration">{{ $vuelo->duracion ?? '2h 30m' }}</div>
                                            <div class="flight-path">
                                                @if($vuelo->directo)
                                                    <i class="bi bi-arrow-right text-success"></i>
                                                    <span class="direct-label">Directo</span>
                                                @else
                                                    <i class="bi bi-arrow-right text-warning"></i>
                                                    <span class="stop-label">Con escala</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="time-section">
                                            <div class="time">{{ date('H:i', strtotime($vuelo->hora_llegada ?? $vuelo->hora)) }}</div>
                                            <div class="airport">{{ $origen->nombre_lugar }}</div>
                                        </div>
                                    </div>

                                    <div class="price-section">
                                        <div class="price-info">
                                            <div class="price">${{ number_format($vuelo->precio->precio_ida ?? 0, 0, ',', '.') }}</div>
                                            <div class="price-per">por persona</div>
                                            <div class="seats-available">{{ $vuelo->asientosDisponibles() ?? 0 }} asientos disponibles</div>
                                        </div>
                                        <a href="{{ route('vuelo.mostrar', $vuelo->id_vuelo) }}" class="select-btn">
                                            <i class="bi bi-arrow-right"></i>
                                            Seleccionar regreso
                                        </a>
                                    </div>
                                </div>

                                <div class="flight-features">
                                    @if($vuelo->wifi)
                                        <span class="feature-badge wifi">
                                            <i class="bi bi-wifi"></i>
                                            WiFi
                                        </span>
                                    @endif
                                    @if($vuelo->reembolsable)
                                        <span class="feature-badge refundable">
                                            <i class="bi bi-arrow-clockwise"></i>
                                            Reembolsable
                                        </span>
                                    @endif
                                    @if($vuelo->directo)
                                        <span class="feature-badge direct">
                                            <i class="bi bi-arrow-right"></i>
                                            Directo
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    @endif

                    <!-- No Results Message -->
                    <div id="sin-resultados" class="no-results" style="display: none;">
                        <div class="no-results-content">
                            <i class="bi bi-search"></i>
                            <h5>No se encontraron vuelos</h5>
                            <p>Intenta ajustar los filtros para ver más resultados</p>
                            <button class="btn btn-primary" onclick="document.getElementById('limpiarFiltros').click()">
                                Limpiar Filtros
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Flight Search Container */
.flight-search-container {
    background: #f8fafc;
    min-height: 100vh;
    padding-top: 2rem;
}

/* Search Header */
.search-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.search-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.route-info {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.airport-info {
    text-align: center;
}

.airport-code {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.airport-name {
    font-size: 0.9rem;
    opacity: 0.9;
}

.flight-path {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.flight-path i {
    font-size: 1.5rem;
}

.flight-line {
    width: 60px;
    height: 2px;
    background: rgba(255, 255, 255, 0.3);
}

.search-details {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.date-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.1rem;
}

.results-count .badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
}

/* Filters Sidebar */
.filters-sidebar {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    position: sticky;
    top: 2rem;
}

.filter-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e2e8f0;
}

.filter-group {
    margin-bottom: 1.5rem;
}

.filter-label {
    display: block;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
}

/* Price Range */
.price-range-container {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 12px;
}

.price-range {
    width: 100%;
    height: 6px;
    border-radius: 3px;
    background: #e2e8f0;
    outline: none;
    -webkit-appearance: none;
    margin-bottom: 0.75rem;
}

.price-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #667eea;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

.price-range::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #667eea;
    cursor: pointer;
    border: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

.price-labels {
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
    color: #718096;
    margin-bottom: 0.5rem;
}

.current-price {
    text-align: center;
}

.price-display {
    background: #667eea;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* Checkbox Group */
.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: background-color 0.2s;
}

.checkbox-item:hover {
    background: #f7fafc;
}

.checkbox-item input[type="checkbox"] {
    display: none;
}

.checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid #cbd5e0;
    border-radius: 4px;
    position: relative;
    transition: all 0.2s;
}

.checkbox-item input[type="checkbox"]:checked + .checkmark {
    background: #667eea;
    border-color: #667eea;
}

.checkbox-item input[type="checkbox"]:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.checkbox-text {
    font-size: 0.9rem;
    color: #4a5568;
}

/* Sort Select */
.sort-select {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    background: white;
    color: #4a5568;
    font-size: 0.9rem;
    transition: border-color 0.2s;
}

.sort-select:focus {
    outline: none;
    border-color: #667eea;
}

/* Clear Filters Button */
.clear-filters-btn {
    width: 100%;
    background: #f7fafc;
    border: 2px solid #e2e8f0;
    color: #4a5568;
    padding: 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.clear-filters-btn:hover {
    background: #edf2f7;
    border-color: #cbd5e0;
}

/* Results Section */
.results-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e2e8f0;
}

.results-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
}

.results-count {
    color: #718096;
    font-size: 0.9rem;
}

.view-options {
    display: flex;
    gap: 0.5rem;
}

.view-btn {
    width: 40px;
    height: 40px;
    border: 2px solid #e2e8f0;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.view-btn.active,
.view-btn:hover {
    border-color: #667eea;
    background: #667eea;
    color: white;
}

/* Flight Cards */
.flights-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.flight-card {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    background: white;
}

.flight-card:hover {
    border-color: #667eea;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    transform: translateY(-2px);
}

.flight-main {
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    gap: 2rem;
    align-items: center;
    margin-bottom: 1rem;
}

/* Airline Section */
.airline-section {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.airline-logo {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.airline-name {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.flight-code {
    font-size: 0.8rem;
    color: #718096;
}

/* Flight Times */
.flight-times {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 1rem;
    align-items: center;
}

.time-section {
    text-align: center;
}

.time {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.airport {
    font-size: 0.9rem;
    color: #718096;
}

.flight-duration {
    text-align: center;
}

.duration {
    font-size: 0.9rem;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.flight-path {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
}

.direct-label,
.stop-label {
    font-size: 0.8rem;
    font-weight: 600;
}

.direct-label {
    color: #38a169;
}

.stop-label {
    color: #d69e2e;
}

/* Price Section */
.price-section {
    text-align: right;
}

.price-info {
    margin-bottom: 1rem;
}

.price {
    font-size: 2rem;
    font-weight: 700;
    color: #667eea;
    margin-bottom: 0.25rem;
}

.price-per {
    font-size: 0.8rem;
    color: #718096;
    margin-bottom: 0.5rem;
}

.seats-available {
    font-size: 0.8rem;
    color: #38a169;
    font-weight: 600;
}

.select-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.select-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

/* Flight Features */
.flight-features {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.feature-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.feature-badge.wifi {
    background: #e6fffa;
    color: #38a169;
}

.feature-badge.refundable {
    background: #fef5e7;
    color: #d69e2e;
}

.feature-badge.direct {
    background: #f0fff4;
    color: #38a169;
}

/* No Results */
.no-results {
    text-align: center;
    padding: 4rem 2rem;
}

.no-results-content i {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.no-results-content h5 {
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.no-results-content p {
    color: #718096;
    margin-bottom: 1.5rem;
}

.suggestions {
    background: #f7fafc;
    padding: 1.5rem;
    border-radius: 12px;
    margin: 1.5rem 0;
    text-align: left;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.suggestions p {
    color: #4a5568;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.suggestions ul {
    color: #718096;
    margin: 0;
    padding-left: 1.5rem;
}

.suggestions li {
    margin-bottom: 0.5rem;
}

/* Responsive Design */
@media (max-width: 992px) {
    .flight-main {
        grid-template-columns: 1fr;
        gap: 1rem;
        text-align: center;
    }
    
    .flight-times {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    
    .price-section {
        text-align: center;
    }
}

@media (max-width: 768px) {
    .search-info {
        flex-direction: column;
        text-align: center;
    }
    
    .route-info {
        gap: 1rem;
    }
    
    .search-details {
        gap: 1rem;
    }
    
    .results-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .filters-sidebar {
        position: static;
        margin-bottom: 2rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const vuelos = document.querySelectorAll('.flight-card');
    const rangoPrecio = document.getElementById('rangoPrecio');
    const precioDisplay = document.querySelector('.price-display');
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
        precioDisplay.textContent = `Hasta $${parseInt(this.value).toLocaleString()}`;
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
        document.querySelectorAll('.checkbox-item input[type="checkbox"]').forEach(cb => cb.checked = false);
        document.getElementById('vuelosDirectos').checked = true;
        
        // Resetear rango de precio
        rangoPrecio.value = precioMaximo;
        precioDisplay.textContent = `Hasta $${precioMaximo.toLocaleString()}`;
        
        // Resetear ordenamiento
        document.getElementById('ordenarPor').value = 'precio';
        
        // Aplicar filtros
        filtrarVuelos();
    });
    
    // Aplicar filtros iniciales
    filtrarVuelos();

    // Toggle fecha_regreso en el formulario de modificar búsqueda
    const tipoViajeRadios = document.querySelectorAll('input[name="tipo_viaje"]');
    const grupoFechaRegreso = document.getElementById('grupo-fecha-regreso');
    const inputFechaRegreso = document.querySelector('input[name="fecha_regreso"]');
    const inputFechaIdaHidden = document.querySelector('input[name="fecha"]');

    function toggleFechaRegreso() {
        if (!grupoFechaRegreso) return;
        const idaRegreso = Array.from(tipoViajeRadios).some(r => r.checked && r.value === 'ida_regreso');
        grupoFechaRegreso.style.display = idaRegreso ? 'block' : 'none';
        if (!idaRegreso && inputFechaRegreso) inputFechaRegreso.value = '';
        if (idaRegreso && inputFechaRegreso && inputFechaIdaHidden) inputFechaRegreso.min = inputFechaIdaHidden.value;
    }

    tipoViajeRadios.forEach(r => r && r.addEventListener('change', toggleFechaRegreso));
    toggleFechaRegreso();
});
</script>
@endpush
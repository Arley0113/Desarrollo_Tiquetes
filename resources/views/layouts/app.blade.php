<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'VuelosYa - Tu mejor opción en viajes')</title>

    {{-- Fuentes y estilos --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/vuelos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
        }
        
        /* Estilos para el menú desplegable del usuario */
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }
        
        .dropdown-item {
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 8px;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
        
        .dropdown-item.text-danger:hover {
            background-color: #fff5f5;
            color: #dc3545 !important;
        }
        
        .navbar-nav .nav-link {
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            transform: translateY(-2px);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <a class="navbar-brand fw-bold text-white d-flex align-items-center" href="{{ route('inicio') }}">
                <i class="bi bi-airplane-fill me-2"></i>
                VuelosYa
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold {{ request()->is('/') ? 'active' : '' }}" href="{{ route('inicio') }}">
                            <i class="bi bi-house me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="#">
                            <i class="bi bi-tags me-1"></i>Ofertas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="#">
                            <i class="bi bi-telephone me-1"></i>Contacto
                        </a>
                    </li>

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-semibold d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        <i class="bi bi-person-fill text-primary"></i>
                                    </div>
                                    <span>{{ Auth::user()->nombres ?? 'Usuario' }}</span>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="border-radius: 15px; min-width: 250px;">
                                <li class="px-3 py-2 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ Auth::user()->nombres ?? 'Usuario' }}</div>
                                            <small class="text-muted">{{ Auth::user()->correo }}</small>
                                        </div>
                                    </div>
                                </li>
                                
                                <li><a class="dropdown-item py-2" href="{{ route('reservas.index') }}">
                                    <i class="bi bi-ticket-perforated me-2 text-primary"></i>Mis Reservas
                                </a></li>
                                
                                <li><a class="dropdown-item py-2" href="{{ route('tiquetes.index') }}">
                                    <i class="bi bi-receipt me-2 text-primary"></i>Mis Tiquetes
                                </a></li>
                                
                                @if(Auth::user()->esAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2 text-warning"></i>Panel Administrativo
                                </a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('usuarios.index') }}">
                                    <i class="bi bi-people me-2 text-warning"></i>Gestionar Usuarios
                                </a></li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item py-2" href="#">
                                    <i class="bi bi-gear me-2 text-secondary"></i>Configuración
                                </a></li>
                                
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item py-2 text-danger" type="submit">
                                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm ms-2 fw-semibold" href="{{ route('login.form') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light btn-sm ms-2 fw-semibold text-primary" href="{{ route('register.form') }}">
                                <i class="bi bi-person-plus me-1"></i>Registrarse
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- CONTENIDO PRINCIPAL --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="mt-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <h5 class="text-white fw-bold mb-2">
                        <i class="bi bi-airplane-fill me-2"></i>VuelosYa
                    </h5>
                    <p class="text-white-50 mb-0">
                        Tu compañero de confianza para viajar por el mundo.
                    </p>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0">
                    <h6 class="text-white fw-bold mb-3">Enlaces</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('inicio') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-3 mb-lg-0">
                    <h6 class="text-white fw-bold mb-3">Servicios</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Reservas</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-white-50">
                        © 2025 <span class="text-white fw-bold">VuelosYa</span> - Todos los derechos reservados
                    </small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-white-50">
                        <a href="#" class="text-white-50 text-decoration-none me-3">Términos y Condiciones</a>
                        <a href="#" class="text-white-50 text-decoration-none">Política de Privacidad</a>
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>

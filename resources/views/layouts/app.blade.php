<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'VuelosYa - Tu mejor opción en viajes')</title>

    {{-- Fuentes y estilos --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vuelos.css') }}">
</head>
<body>
    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('inicio') }}">VuelosYa</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('inicio') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>

                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Panel</a></li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-light btn-sm ms-2" type="submit">Salir</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="btn btn-outline-primary btn-sm ms-2" href="{{ route('login.form') }}">Iniciar sesión</a></li>
                        <li class="nav-item"><a class="btn btn-primary btn-sm ms-2" href="{{ route('register.form') }}">Registrarse</a></li>
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
    <footer class="text-center py-4 bg-dark mt-5">
        <small class="text-light-50">© 2025 <span class="text-primary">VuelosYa</span> - Todos los derechos reservados</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

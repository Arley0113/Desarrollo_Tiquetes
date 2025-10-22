 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Ofertas de Vuelos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vuelos.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href=" route('inicio') ">VuelosYa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="header-busqueda text-center text-white d-flex align-items-center justify-content-center">
        <div class="container">
            <h1 class="fw-bold mb-4">Encuentra tu vuelo ideal</h1>

            <form method="GET" action="{{ route('inicio') }}" class="row g-2 justify-content-center buscador-form bg-white p-3 rounded shadow">
                <div class="col-12 col-md-3">
                    <input type="text" name="origen" class="form-control" placeholder="Origen" value="{{ $origen ?? '' }}">
                </div>
                <div class="col-12 col-md-3">
                    <input type="text" name="destino" class="form-control" placeholder="Destino" value="{{ $destino ?? '' }}">
                </div>
                <div class="col-12 col-md-3">
                    <input type="date" name="fecha" class="form-control" value="{{ $fecha ?? '' }}">
                </div>
                <div class="col-12 col-md-2">
                   <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </form>
        </div>
    </header>

  

    <main class="container my-5">
        <div class="row g-4">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://media.istockphoto.com/id/611891416/photo/santa-rosa-de-cabal-hot-springs.jpg?s=2048x2048&w=is&k=20&c=o7C8DmZFSRMnnvW548gskWH5kL8eIyDV78PLbFTvLBo=" class="card-img-top" alt="Nueva York">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Pereira</h5>
                        <p class="text-muted">Vuelos desde $280.000 COP</p>
                        <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://media.istockphoto.com/id/1453256961/photo/aerial-view-of-modern-bogota-cityscape-in-colombia-in-the-afternoon.jpg?s=2048x2048&w=is&k=20&c=aVh3UzSwTyOBOqx3jNR25439oH-nKGiXKObnaTm7dyk=" class="card-img-top" alt="Miami">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Bogota</h5>
                        <p class="text-muted">Vuelos desde $180.000 COP</p>
                        <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://media.istockphoto.com/id/856585242/photo/view-over-the-city-of-yerevan-capital-of-armenia-with-the-two-peaks-of-the-mount-ararat-in-the.jpg?s=2048x2048&w=is&k=20&c=x8GmlmAEy1ArtOdIM3gcq3fJ9QX32UN94scFmMvtgII=" class="card-img-top" alt="Los Ángeles">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Armenia</h5>
                        <p class="text-muted">Vuelos desde $420.000 COP</p>
                        <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://cdn.pixabay.com/photo/2015/12/01/20/28/road-1072828_1280.jpg" class="card-img-top" alt="San Francisco">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Santa Marta</h5>
                        <p class="text-muted">Vuelos desde $395.000 COP</p>
                        <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://cdn.pixabay.com/photo/2022/11/02/16/47/saline-7565442_1280.jpg" class="card-img-top" alt="Destino">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Riohacha</h5>
                        <p class="text-muted">Vuelos desde $280.000 COP</p>
                        <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                    </div>
                </div>
            </div>

            
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://cdn.pixabay.com/photo/2020/01/23/19/09/cartagena-de-indias-4788526_1280.jpg" class="card-img-top" alt="Destino">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Cartagena</h5>
                        <p class="text-muted">Vuelos desde $350.000 COP</p>
                        <a href="#" class="btn btn-primary w-100">Ver vuelos</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <section class="py-5 text-center" style="background: linear-gradient(90deg,#155DFC 0%, #9810FA 50%, #E60076 100%); color: white;">
        <div class="container">
            <h2 class="fw-bold">¿Listo para tu próxima aventura?</h2>
            <p class="mb-4">Únete a millones de viajeros que confían en nosotros</p>
            <a href="#" class="btn btn-light btn-lg">Comenzar ahora</a>
        </div>
    </section>


    <footer class="text-center py-4 bg-light mt-4">
        <small class="text-muted">© 2025 VuelosYa - Todos los derechos reservados</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

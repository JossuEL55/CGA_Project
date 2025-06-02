<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Mi Aplicación') }}</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    {{-- Tu CSS personalizado --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2E7D32;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Mi Aplicación') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registro</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('ordenes.index') }}">Órdenes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('plantas.index') }}">Plantas</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">{{ Auth::user()->name }}</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Salir
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Contenido principal --}}
    <main class="container my-4 flex-fill">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-success text-white text-center py-3 mt-auto">
        <div class="container">
            <small>© {{ date('Y') }} {{ config('app.name', 'Mi Aplicación') }}. Todos los derechos reservados.</small>
        </div>
    </footer>

    {{-- Bootstrap 5 JS + Popper --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Scripts personalizados (si tienes) --}}
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
</body>
</html>

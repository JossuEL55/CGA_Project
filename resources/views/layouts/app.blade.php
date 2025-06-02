{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'CGA OIL') }}</title>

    {{-- Carga de Bootstrap (puedes quitarlo si prefieres solo CSS personalizado) --}}
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-...tu-hash..."
      crossorigin="anonymous"
    />

    {{-- Bootstrap Icons --}}
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />

    {{-- Tu CSS personalizado (el que ya enviaste) --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    
    {{-- Si quieres añadir estilos “inline” específicos para ciertas vistas, puedes usar stack --}}
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Navbar con tu esquema de color verde --}}
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            {{-- Logo a la izquierda --}}
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                {{-- Si tienes un logo, por ejemplo: --}}
                <img src="{{ asset('images/cgaoil.png') }}" alt="Logo CGA OIL" height="40">
                {{-- O simplemente el nombre --}}
                CGA OIL
            </a>
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarNav"
              aria-controls="navbarNav"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                {{-- Enlaces de navegación a la izquierda --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('ordenes.dashboard') ? 'active' : '' }}"
                               href="{{ route('ordenes.dashboard') }}">
                               <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('ordenes.*') && !request()->routeIs('ordenes.dashboard') && !request()->routeIs('ordenes.historial*') ? 'active' : '' }}"
                               href="{{ route('ordenes.index') }}">
                               <i class="bi bi-list-check"></i> Órdenes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('ordenes.historial*') ? 'active' : '' }}"
                               href="{{ route('ordenes.historial') }}">
                               <i class="bi bi-clock-history"></i> Historial
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}"
                               href="{{ route('clientes.index') }}">
                               <i class="bi bi-people"></i> Clientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('tecnicos.*') ? 'active' : '' }}"
                               href="{{ route('tecnicos.index') }}">
                               <i class="bi bi-person-badge"></i> Técnicos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('plantas.*') ? 'active' : '' }}"
                               href="{{ route('plantas.index') }}">
                               <i class="bi bi-building"></i> Plantas
                            </a>
                        </li>
                    @endauth
                </ul>

                {{-- Enlaces de perfil y logout a la derecha --}}
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                Iniciar Sesión
                            </a>
                        </li>
                        @if(Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                Registrarse
                            </a>
                        </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a
                              class="nav-link dropdown-toggle"
                              href="#"
                              id="userDropdown"
                              role="button"
                              data-bs-toggle="dropdown"
                              aria-expanded="false"
                            >
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-gear"></i> Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                        </button>
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
    <main class="container flex-grow-1 my-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-success text-white text-center py-3 mt-auto">
        <div class="container">
            <small>© {{ date('Y') }} CGA OIL. Todos los derechos reservados.</small>
        </div>
    </footer>

    {{-- Scripts de Bootstrap --}}
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-...tu-hash..."
      crossorigin="anonymous"
    ></script>

    @stack('scripts')
</body>
</html>

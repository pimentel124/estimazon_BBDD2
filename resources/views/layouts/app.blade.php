<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/webp" href="{{ asset('logo.webp') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="logo pe-3">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('logo.webp') }}" alt="Logo" width="40" height="40">
                    </a>
                </div>
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif


                        @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->full_name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('perfil') }}">Mi cuenta</a>
                                    @if(Auth::user()->role_id == 2)
                                    <a class="dropdown-item" href="{{ route('subir_producto') }}">Añadir producto</a>
                                    <a class="dropdown-item" href="{{ route('myprods') }}">Modificar/Eliminar producto</a>
                                    <a class="dropdown-item" href="{{ route('pedidos') }}">Ventas</a>
                                    @endif
                                    @if(Auth::user()->role_id == 3)
                                    <a class="dropdown-item" href="{{ route('controlador') }}">Controlador</a>
                                    @endif
                                    @if(Auth::user()->role_id == 4)
                                    <a class="dropdown-item" href="{{ route('repartidor') }}">Reparto</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @if(Auth::user()->role_id == 1)
                                @if (Route::has('carrito'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('carrito') }}">
                                            <img src="{{ asset('images/carrito.png') }}" alt="Carrito" width="23" height="23">
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 mb-5">
            @yield('content')
        </main>
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>&copy; 2023 Estimazon. Álvaro, Alejandro, Gregori.</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>


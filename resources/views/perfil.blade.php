@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h1>Bienvenido, {{ auth()->user()->full_name }}</h1>
            @if (auth()->check())
                <p>Tipo: {{ auth()->user()->role_id == 1 ? 'Comprador' : (auth()->user()->role_id == 2 ? 'Vendedor' : 'Desconocido') }}</p>
            @endif <!-- Resto de tu contenido de perfil -->
                <form method="POST" action="{{ route('actualizar-perfil') }}">
                    @csrf

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label for="name">Nombre</label>
                        <input id="name" type="text" class="form-control" name="full_name" value="{{ auth()->user()->full_name }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Correo</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Nueva contraseña">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirmar contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Actualizar Perfil</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
@endsection

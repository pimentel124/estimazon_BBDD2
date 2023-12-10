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
            <h1>Checkout</h1>
            <form action="{{ route('process_checkout') }}" method="post">
                @csrf
                <div class="form-group mb-3">
                    <label for="provincia">Provincia:</label>
                    <select class="form-control" id="provincia" name="provincia" required>
                        <option value="">Selecciona una provincia</option>

                        @foreach($provincias as $provincia)
                            <option value="{{ $provincia->id }}">{{ $provincia->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="municipio">Municipio:</label>
                    <select class="form-control" id="municipio" name="municipio" required>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>
                <div class="form-group mb-3">
                    <label for="numero">Número:</label>
                    <input type="text" class="form-control" id="numero" name="numero" required>
                </div>
                <div class="form-group mb-3">
                    <label for="piso">Piso:</label>
                    <input type="text" class="form-control" id="piso" name="piso" required>
                </div>
                <button type="submit" class="btn btn-primary">Realizar Pedido</button>
            </form>
        </div>
    </div>
</div>

<script>
// Agrega un script para manejar la carga dinámica de municipios en función de la provincia seleccionada
document.getElementById('provincia').addEventListener('change', function () {
    var provinciaId = this.value;

    // Llamada AJAX para obtener los municipios en función de la provincia seleccionada
    fetch('{{ url('/getMunicipiosByProvince/') }}/' + provinciaId)
        .then(response => response.json())
        .then(data => {
            // Llena el select de municipios con los datos obtenidos
            var municipioSelect = document.getElementById('municipio');
            municipioSelect.innerHTML = '';
            data.forEach(municipio => {
                var option = document.createElement('option');
                option.value = municipio.id;
                option.text = municipio.name;
                municipioSelect.add(option);
            });
        });
});
</script>

</body>
</html>

@endsection

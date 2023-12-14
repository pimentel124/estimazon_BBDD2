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
                        @if ($addresses->count() > 0)
                            <h2>Direcciones</h2>
                            <div class="addressescontainer my-3">
                            @foreach ($addresses as $address)
                                <div class="my-1 py-2 px-2 bg-light border rounded-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="address_id"
                                            id="address{{ $address->id }}" value="{{ $address->id }}" {{ $loop->first ? 'checked' : '' }}>
                                        <label class="form-check-label" for="address{{ $address->id }}">
                                            {{ implode(', ', array_filter([$address->direction, $address->number, $address->floor, $address->municipio->name])) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            <h2>Añadir nueva dirección</h2>
                        @endif

                        <div class="form-group mb-3">
                            <label for="provincia">Provincia:</label>
                            <select class="form-control" id="provincia" name="provincia"
                                @unless ($addresses->count() > 0) required @endunless>
                                <option value="">Selecciona una provincia</option>

                                @foreach ($provincias as $provincia)
                                    <option value="{{ $provincia->id }}">{{ $provincia->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="municipio">Municipio:</label>
                            <select class="form-control" id="municipio" name="municipio"
                                @unless ($addresses->count() > 0) required @endunless>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="direccion">Dirección:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                                @unless ($addresses->count() > 0) required @endunless>
                        </div>
                        <div class="form-group mb-3">
                            <label for="numero">Número:</label>
                            <input type="text" class="form-control" id="numero" name="numero"
                                @unless ($addresses->count() > 0) required @endunless>
                        </div>
                        <div class="form-group mb-3">
                            <label for="piso">Piso:</label>
                            <input type="text" class="form-control" id="piso" name="piso"
                                @unless ($addresses->count() > 0) required @endunless>
                        </div>
                        <button type="submit" class="btn btn-primary">Realizar Pedido</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            // Agrega un script para manejar la carga dinámica de municipios en función de la provincia seleccionada
            document.getElementById('provincia').addEventListener('change', function() {
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

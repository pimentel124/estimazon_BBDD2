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
                <h1>{{ $product->name }}</h1>
                <div class="container">
                    <div class="row">
                        <!-- Image Column -->
                        <div class="col-md-4">
                            <td>
                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->id }}" width="400"length="40">
                            </td>
                        </div>
                        <!-- Description and Vendor Information Columns -->
                        <div class="col-md-8">
                            <div class="row">
                                <!-- Description Column -->
                                <div class="col-md-6">
                                    <h4>Descripción</h4>
                                    <p>{{ $product->description }}</p>
                                </div>
                                <!-- Vendor Information Square Container -->
                                <div class="col-md-6">
                                    @if ($product->vendor)
                                        <div class="vendor-info-container bg-light rounded p-3 border border-gray">
                                            <h4>Información del vendedor</h4>
                                            <p>Nombre: {{ $product->vendor->name }}</p>
                                            <p>Descripción vendedor: {{ $product->vendor->description }}</p>
                                            <p>Precio: {{ $product->price }} €</p>
                                            <!-- Cantidad Text and Dropdown Selector -->
                                            <label for="cantidad">Cantidad:</label>
                                            <select id="cantidad" name="cantidad">
                                                @for ($i = 1; $i <= 30; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <!-- Añadir al carrito -->
                                            <button class="btn btn-primary" id="addToCartBtn">Añadir al carrito</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display other vendors -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h2>Otros Vendedores</h2>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>

@endsection

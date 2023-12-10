@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Landing Page</h1>

        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('products.show', ['id' => $product->id]) }}">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td>{{ $product->description }}</td>
                                <td><img src="{{ asset('storage/uploads/' . basename($product->image_url)) }}" alt="{{ $product->name }}" width="100"></td>
                                <td>{{ $product->getPrice() }} €</td>
                                <td>{{ $product->productStocks->first()->amount ?? 0 }}</td>
                                <td>
                                    <form action="{{ route('carrito.add', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Añadir al Carrito</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

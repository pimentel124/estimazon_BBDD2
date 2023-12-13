<!-- cart.blade.php -->

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
                <h1>Carrito</h1>
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
                        @foreach($order_items as $item)
                            <tr>
                                <td>{{ $item->product->name}}</td>
                                <td>{{ $item->product->description }}</td>
                                <td><img src="{{ asset('storage/uploads/' . basename($item->product->image_url)) }}" alt="{{ $item->product->name }}" width="100"></td>
                                <td>{{ $item->product->getPrice($item->vendor_id) }} €</td>
                                <td>{{ $item->quantity ?? 0 }}</td>
                                <td>
                                    <form action="{{ route('carrito.remove', ['productStock' => $item->product_id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Quitar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- "Pagar" button -->
                <div class="text-center">
                    <a href="{{ route('checkout') }}" class="btn btn-primary">Pagar</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

@endsection

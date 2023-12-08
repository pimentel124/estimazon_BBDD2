@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Mis Productos</h2>

        @if($userProducts->isEmpty())
            <p>No has subido ningún producto.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                            @if($product->image_url)
                                <img src="{{ asset('storage/uploads/' . basename($product->image_url)) }}" alt="{{ $product->name }}" width="100">
                            @endif
                            </td>
                            <td>{{ $product->getPrice() }} €</td>
                            <td>
                            <form action="{{ route('products.edit', $product->id) }}" method="GET" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </form>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

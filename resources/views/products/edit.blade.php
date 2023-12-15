@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Producto</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Descripción:</label>
                <textarea name="description" id="description" class="form-control" required>{{ $product->description }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="price">Precio:</label>
                <input type="number" name="price" step="0.01" id="price" value="{{ $product->getPrice() }}" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="image">Imagen</label>
                <input type="file" name="image" id="image" class="form-control-file" required>
            </div>

            <div class="form-group mb-3">
                <label for="amount">Cantidad</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Producto</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Add form fields for editing the product -->
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea name="description" id="description" class="form-control" required>{{ $product->description }}</textarea>
            </div>

            <!-- Add more fields as needed -->

            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
        </form>
    </div>
@endsection

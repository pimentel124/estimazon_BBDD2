@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 100vh;">
        <h2>Subir Producto</h2>

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="name">Nombre del Producto</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="category">Categoría</label>
                <select name="category" id="category" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="amount">Cantidad</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="unit_price">Precio Unitario</label>
                <input type="number" name="unit_price" id="unit_price" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="image">Imagen</label>
                <input type="file" name="image" id="image" class="form-control-file" required>
            </div>

            <button type="submit" class="btn btn-primary">Subir Producto</button>
        </form>
    </div>
@endsection

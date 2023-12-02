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
                        <th>Categoría</th>
                        <!-- Add more columns as needed -->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->category->name }}</td>
                            <!-- Add more columns as needed -->
                            <td>
                                <!-- Add actions like edit or delete -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

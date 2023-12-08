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
                <h1>Landing Page</h1>


                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Imagen</th>
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
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
</body>

</html>

@endsection

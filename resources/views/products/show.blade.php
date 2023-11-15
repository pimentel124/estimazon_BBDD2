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
                <h1>{{ $product-> name }}</h1>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" style="max-width: 100%;">
                        </div>
                        <div class="col-md-6">
                        <h4>Descripción</h4>
                            <p>{{ $product->description }}</p>
                            <p>Price: {{ $product->price }} €</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

@endsection

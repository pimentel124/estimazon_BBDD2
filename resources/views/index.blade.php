@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
    </head>

    <body>


        <div class="container-fluid">
            <div class="row">
                <div class="col-3 bg-light sidebar">
                    <h2>Categories</h2>
                    <ul class="list-unstyled">
                        <li><a href="#">Category 1</a></li>
                        <li><a href="#">Category 2</a></li>
                        <!-- Add more categories as needed -->
                    </ul>
                </div>
                <div class="col-9">
                    @foreach ($products as $product)
                        <div class="row d-flex row-height p-1">
                            <div class="col-4 flex-fill">
                                <div class="image-tab">
                                    <img class="product-image" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                </div>
                            </div>
                            <div class="col-8 flex-fill">
                                <h3>
                                    
                                    <a href="{{ route('products.show', ['id' => $product->id]) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <h5>Vendor: {{ $product->vendor_name }}</h5>
                                <p>{{ $product->description }}</p>
                                <p>{{ $product->price }} €</p>

                                <form action="{{ route('carrito.add', ['product' => $product->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Add to cart</button>
                                </form>

                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>

    </body>

    </html>
@endsection

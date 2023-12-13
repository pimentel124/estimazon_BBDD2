@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
    </head>

    <body>


        <div class="container-fluid">
            <div class="row">
                <div class="col-9">
                    @foreach ($products as $product)
                        <div class="row d-flex row-height p-1">
                            <div class="col-4 flex-fill">
                                <div class="image-tab">
                                    <img src="{{ asset('storage/uploads/' . basename($product->image_url)) }}"
                                        alt="{{ $product->name }}" width="100">
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
                                @if (Auth::user()->role_id == 1)
                                    @if (Route::has('carrito'))
                                        <form action="{{ route('carrito.addToCart', $product->product_stockId) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Add to cart</button>
                                        </form>
                                    @endif
                                @endif
                                @if (Auth::user()->role_id == 2)
                                    <form action="{{ route('carrito.addToCart', $product->product_stockId) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Sell this product</button>
                                    </form>
                                @endif

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

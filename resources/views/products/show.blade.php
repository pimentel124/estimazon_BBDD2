@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html>

    <head>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row m-5">

                @php
                    $firstProductStock = $product->productStocks->first();
                @endphp

                <!-- Image Column -->

                <div class="col-4 flex-fill p-3">
                    <div class="image-tab">
                    <img src="{{ asset('storage/uploads/' . basename($product->image_url)) }}" alt="{{ $product->name }}" width="100">                          </div>
                </div>

                <!-- Description and Vendor Information Columns -->
                <div class="col-8 flex-fill p-3">
                    <h3>{{ $product->name }}</h3>
                    <h5>Vendor: {{ $firstProductStock->vendor->full_name }}</h5>
                    <p>{{ $product->description }}</p>
                    <p>{{ $firstProductStock->unit_price }} €</p>
                    @if(Auth::user()->role_id == 2)
                        <form action="{{ route('carrito.addToCart', $firstProductStock->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add to cart</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </body>
    </html>
@endsection

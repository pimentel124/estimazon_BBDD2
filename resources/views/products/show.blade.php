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

                    <form action="{{ route('carrito.addToCart', $firstProductStock->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add to cart</button>
                    </form>

                </div>
            </div>

            <!-- Display other vendors -->
            <div class="row m-5">
                <div class="row">
                    <h2>Otros Vendedores</h2>
                </div>
                @foreach ($product->productStocks->skip(1) as $stock)
                <div class="row d-flex row-height p-1">
                    <h5>Vendido por: {{ $stock->vendor->full_name }}</h5>
                    <p>{{ $stock->unit_price }} €</p>
                    <form action="{{ route('carrito.addToCart', ['productStock' => $stock->id, 'vendor_id' => $stock->vendor_id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add to cart</button>
                    </form>
                </div>
                <hr>
                @endforeach
            </div>
        </div>

    </body>

    </html>
@endsection

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
                    @if(Auth::user()->role_id == 1)
                        <form action="{{ route('carrito.addToCart', $firstProductStock->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add to cart</button>
                        </form>
                    @endif

                    @if(Auth::user()->role_id == 2)
                    <button type="button" id="AddStock" class="btn btn-primary">Añadir stock</button>
                    @endif


                    <!-- Display other vendors -->
                    <div class="row m-5">
                        <div class="row">
                            <h2>Otros Vendedores</h2>
                        </div>
                        @foreach ($product->productStocks->skip(1) as $stock)
                        <div class="row d-flex row-height p-1">
                            <h5>Vendido por: {{ $stock->vendor->full_name }}</h5>
                            <p>{{ $stock->unit_price }} €</p>
                            @if(Auth::user()->role_id == 1)
                            <form action="{{ route('carrito.addToCart', ['productStock' => $stock->id, 'vendor_id' => $stock->vendor_id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Añadir stock</button>
                            </form>
                            @endif
                        </div>
                        <hr>
                        @endforeach
                    </div>
                    
                    @if(Auth::user()->role_id == 2)
                        <!-- Modal -->
                        <button type="button" id="AddStock" class="btn btn-primary">Añadir stock</button>
                        <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addStockModalLabel">Añadir stock</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('products.addStock', $product->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="amount" class="form-label">Cantidad</label>
                                                <input type="number" class="form-control" id="amount" name="amount">
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Precio</label>
                                                <input type="number" class="form-control" id="price" name="price">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Añadir stock</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif
                </div>
            </div>
        </div>
    </body>
    </html>
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('AddStock').addEventListener('click', function() {
    var myModal = new bootstrap.Modal(document.getElementById('addStockModal'), {});
    myModal.show();
  });
});
    </script>
@endsection

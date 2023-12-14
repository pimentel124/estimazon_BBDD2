@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html>

    <head>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row m-5 bg-light border rounded-2">

                @php
                    $firstProductStock = $product->productStocks->first();
                @endphp

                <!-- Image Column -->

                <div class="col-4 flex-fill p-3">
                    <div class="product-image-container">
                        <img class="product-image" src="{{ asset('storage/uploads/' . basename($product->image_url)) }}"
                            alt="{{ $product->name }}">
                    </div>
                </div>

                <!-- Description and Vendor Information Columns -->
                <div class="col-8 p-3">
                    <h3>{{ $product->name }}</h3>
                    <h5>Vendido por: {{ $firstProductStock->vendor->full_name }}</h5>
                    <p class="text-break">
                        {{ $product->description }}
                    </p>

                    <p>{{ $firstProductStock->unit_price }} €</p>
                    @auth


                        @if (Auth::user()->role_id == 1)
                            <form action="{{ route('carrito.addToCart', $firstProductStock->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                            </form>
                        @endif


                        @if (Auth::user()->role_id == 2)
                            <button type="button" id="AddStock" class="btn btn-primary">Añadir stock</button>
                        @endif


                    @endauth
                    <!-- Display other vendors -->
                </div>
            </div>
            <div class="row ms-5">
                <h2>Otros Vendedores</h2>
            </div>
            @foreach ($product->productStocks->skip(1) as $stock)
                <div class="row mx-5 my-3 p-4 bg-light border rounded-2">
                    <h5>Vendido por: {{ $stock->vendor->full_name }}</h5>
                    <p>{{ $stock->unit_price }} €</p>
                    @auth
                        @if (Auth::user()->role_id == 1)
                            <form
                                action="{{ route('carrito.addToCart', ['productStock' => $stock->id, 'vendor_id' => $stock->vendor_id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="max-width: 25%;">Añadir al
                                    carrito</button>
                            </form>
                        @endif
                    @endauth

                </div>
            @endforeach

            @auth
                @if (Auth::user()->role_id == 2)
                    <!-- Modal -->
                    <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addStockModalLabel">Añadir stock</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('products.addStock') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="mb-3">
                                            <label for="amount" class="form-label">Cantidad</label>
                                            <p>En caso de que usted ya tenga subido stock, la cantidad de artículos se
                                                sumará a la ya existente</p>
                                            <input type="number" class="form-control" id="amount" name="amount">
                                        </div>
                                        <div class="mb-3">

                                            <label for="price" class="form-label">Precio</label>
                                            <p>En caso de que usted ya tenga subido stock, el precio será sobreescrito</p>
                                            <input type="number" step="0.01" class="form-control" id="price" name="price">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Añadir stock</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

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

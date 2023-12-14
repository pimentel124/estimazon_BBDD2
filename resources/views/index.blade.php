@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html>

    <head>
    </head>

    <body>


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @foreach ($products as $product)
                        <div class="row mx-5 my-2 p-3 bg-light border rounded-2">
                            <div class="col-4 flex-fill">
                                <div class="product-image-container">
                                    <img class="product-image" src="{{ asset('storage/uploads/' . basename($product->image_url)) }}" alt="{{ $product->name }}">
                                </div>
                            </div>
                            <div class="col-8 flex-fill">
                                <h3>

                                    <a href="{{ route('products.show', ['id' => $product->id]) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <h5>Vendedor: {{ $product->vendor_name }}</h5>
                                <p class="text-wrap">{{ $product->description }}</p>
                                <p>{{ $product->price }} €</p>
                                @auth
                                    
                                
                                @if (Auth::user()->role_id == 1)
                                    @if (Route::has('carrito'))
                                        <form action="{{ route('carrito.addToCart', $product->product_stockId) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                                        </form>
                                    @endif
                                @endif
                                @if (Auth::user()->role_id == 2)
                                    <button type="button" class="btn btn-primary btn-sm open-modal" data-toggle="modal" data-target="#myModal" data-id="{{ $product->id }}">Añadir stock</button>
                                @endif
                                @endauth

                            </div>
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
                                        <input type="hidden" id="product_id" name="product_id" value=""/>
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
        </div>

    </body>

    </html>
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            var buttons = document.querySelectorAll('.open-modal');

            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    
                    var productId = this.getAttribute('data-id');
                    console.log(productId);
                    var input = document.querySelector('.modal-body #product_id');
                    input.value = productId;
                    var myModal = new bootstrap.Modal(document.getElementById('addStockModal'), {});
                    myModal.show();
                });


            });

            
        });
    </script>
@endsection

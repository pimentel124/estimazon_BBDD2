@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Detalle del Pedido</h1>

                <h2>Dirección de Entrega:</h2>
                <p>
                    {{ $pedido->deliveryAddress->direction }},
                    {{ $pedido->deliveryAddress->number }},
                    @if ($pedido->deliveryAddress->floor)
                        Piso {{ $pedido->deliveryAddress->floor }},
                    @endif
                    {{ $pedido->deliveryAddress->municipio->name }},
                    {{ $pedido->deliveryAddress->municipio->provincia->name }}
                </p>

                <h2>Productos:</h2>
                <ul>
                    @foreach($pedido->items as $orderItem)
                        <li>
                            <strong>Producto:</strong> {{ $orderItem->product->name }}<br>
                            <strong>Cantidad:</strong> {{ $orderItem->quantity }}<br>
                        </li>
                        <br>
                    @endforeach
                </ul>
                <h2>Añadir Incidencia:</h2>
                <form action="{{ route('pedidos.incidencias.store', ['pedido' => $pedido->id]) }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Añadir Incidencia</button>
                </form>
                <a href="{{ route('index') }}" class="btn btn-primary">Volver</a>
            </div>
        </div>
    </div>
@endsection

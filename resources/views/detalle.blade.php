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
                <div class="form-group mb-3">
                    <label for="provincia">Empresa distribuidora:</label>
                    <select class="form-control" id="provincia" name="provincia" required>
                        <option value="">Selecciona provincia</option>
                        @foreach($provincias as $provincia)
                            <option value="{{ $provincia->id }}">{{ $provincia->name }}</option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('index') }}" class="btn btn-primary">Volver</a>
            </div>
        </div>
    </div>
@endsection

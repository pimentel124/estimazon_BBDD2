@extends('layouts.app')

@section('content')
<div class="container" style="min-height: 120vh;">
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
                <form action="{{ route('guardar-envio', ['orderId' => $pedido->id]) }}" method="post">
                    @csrf
                    @method('put')

                    <div class="form-group mb-3">
                        <label for="empresa">Empresa distribuidora:</label>
                        <select class="form-control" id="empresa" name="empresa" required>
                            <option value="">Selecciona empresa</option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}">{{ $empresa->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
@endsection

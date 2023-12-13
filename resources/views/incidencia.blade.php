@extends('layouts.app')

@section('content')
<div class="container" style="min-height: 150vh;">
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
                <h2>Estado del pedido:</h2>
                <p>
                    @if ($pedido->status == 'cart')
                        {{ __('En el carrito') }}
                    @elseif ($pedido->status == 'confirmed')
                        {{ __('Confirmado') }}
                    @elseif ($pedido->status == 'to_center')
                        {{ __('Enviado a Estimazon') }}
                    @elseif ($pedido->status == 'delivering')
                        {{ __('En proceso de repartición') }}
                    @elseif ($pedido->status == 'recieved')
                        {{ __('Entregado al comprador') }}
                    @elseif ($pedido->status == 'alt_recieved')
                        {{ __('Entregado a otro domicilio') }}
                    @elseif ($pedido->status == 'refused')
                        {{ __('Comprador no encontrado') }}
                    @elseif ($pedido->status == 'returned')
                        {{ __('Devolución') }}
                    @endif
                </p>
                <form action="{{ route('pedidos.updateStatus', ['pedido' => $pedido->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="status">Cambiar Estado:</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="delivering" @if($pedido->status == 'delivering') selected @endif>En proceso de repartición</option>
                            <option value="recieved" @if($pedido->status == 'recieved') selected @endif>Entregado al comprador</option>
                            <option value="alt_recieved" @if($pedido->status == 'alt_recieved') selected @endif>Entregado a otro domicilio</option>
                            <option value="refused" @if($pedido->status == 'refused') selected @endif>Comprador no encontrado</option>
                            <option value="returned" @if($pedido->status == 'returned') selected @endif>Devolución</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
@endsection

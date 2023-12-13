@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Ventas</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Vendedor</th>
                            <th>Tiempo transcurrido</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->product->name }}</td>
                                <td>{{ $pedido->quantity }}</td>
                                <td>{{ $pedido->vendor->full_name }}</td>
                                <td>{{ $pedido->dias_restantes }} días</td>
                                <td>
                                    <!-- Verifica si el estado es "sent" y cambia el botón en consecuencia -->
                                    @if ($pedido->order->status == 'to_center')
                                        <span class="btn btn-success disabled">Enviado</span>
                                    @else
                                        <!-- Si no es "sent", muestra el botón "Enviar" como antes -->
                                        <form action="{{ route('enviar_pedido', ['pedido' => $pedido->order_id]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

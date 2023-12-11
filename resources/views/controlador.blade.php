@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 100vh;">
        <div class="row">
            <div class="col-md-12">
                <h1>Controlador</h1>
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
                                    @if ($pedido->order->status == 'sent')
                                        <span class="btn btn-success disabled">Enviado</span>
                                        <a href="{{ route('pedidos.show', ['pedido' => $pedido->order_id]) }}" class="btn btn-warning">Completar</a>
                                    @else
                                    <span class="btn btn-primary disabled">Pendiente</span>

                                        @if ($pedido->dias_restantes >= 5)
                                        <a href="{{ route('avisar', ['vendedorId' => $pedido->vendor->id]) }}" class="btn btn-warning">Avisar</a>
                                        @endif
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

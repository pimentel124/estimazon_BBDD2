@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Controlador</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Vendedor</th>
                            <th>Tiempo restante</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->product->name }}</td>
                                <td>{{ $pedido->quantity }}</td>
                                <td>{{ $pedido->vendor->full_name }}</td>
                                <td>{{ $pedido->dias_restantes }}</td>
                                <td>
                                    <!-- Verifica si el estado es "sent" y cambia el botón en consecuencia -->
                                    @if ($pedido->order->status == 'sent')
                                        <span class="btn btn-success disabled">Enviado</span>
                                    @else
                                        <span class="btn btn-success disabled">Pendiente</span>
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

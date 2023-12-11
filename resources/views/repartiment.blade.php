@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 100vh;">
        <div class="row">
            <div class="col-md-12">
                <h1>Reparto</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Vendedor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->product->name }}</td>
                                <td>{{ $pedido->quantity }}</td>
                                <td>{{ $pedido->vendor->full_name }}</td>
                                <td>
                                    <!-- Agrega un botón "Consultar" que redirige al enlace /pedidos/{pedidoId} -->
                                    <a href="{{ route('pedidos.incidencia', ['pedido' => $pedido->order_id]) }}" class="btn btn-danger">Incidencia</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

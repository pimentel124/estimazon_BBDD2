@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 100vh;">
        <div class="row">
            <div class="col-md-12">
                <h1>Repartidor</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto/s</th>
                            <th>Vendedor/es</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>
                                    @foreach($pedido->items as $item)
                                        {{ $item->product->name }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @php
                                        $vendedores = [];
                                    @endphp

                                    @foreach($pedido->items as $item)
                                        @php
                                            $vendedorId = $item->vendor->id;
                                            $vendedorNombre = $item->vendor->full_name;
                                            // Verifica si el vendedor ya ha sido agregado
                                            if (!in_array($vendedorId, array_column($vendedores, 'id'))) {
                                                $vendedores[] = ['id' => $vendedorId, 'nombre' => $vendedorNombre];
                                            }
                                        @endphp
                                    @endforeach

                                    @foreach($vendedores as $vendedor)
                                        {{ $vendedor['nombre'] }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('pedidos.incidencia', ['pedido' => $pedido->id]) }}" class="btn btn-danger">Incidencia</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection



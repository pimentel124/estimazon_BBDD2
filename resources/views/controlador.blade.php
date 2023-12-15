@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 100vh;">
        <div class="row">
            <div class="col-md-12">
                <h1>Controlador</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nº Pedido</th>
                            <th>Producto/s</th>
                            <th>Vendedor/es</th>
                            <th>Tiempo transcurrido</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->id }}</td>
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
                                            $enviado = $item->enviado ?? false;
                                            // Verifica si el vendedor ya ha sido agregado
                                            if (!in_array($vendedorId, array_column($vendedores, 'id'))) {
                                                $vendedores[] = ['id' => $vendedorId, 'nombre' => $vendedorNombre, 'enviado' => $enviado];
                                            }
                                        @endphp
                                    @endforeach

                                    @foreach($vendedores as $vendedor)
                                        {{ $vendedor['nombre'] }}<br>
                                    @endforeach
                                </td>
                                <td>{{ $pedido->dias_restantes }} días</td>
                                <td>
                                    <!-- Verifica el estado y muestra los botones en consecuencia -->
                                    @if ($pedido->status == 'confirmed')
                                        <span class="btn btn-primary disabled">Pendiente</span>
                                        @if ($pedido->dias_restantes >= 5)
                                            @foreach($vendedores as $vendedor)
                                                @if (!$vendedor['enviado'])
                                                    <a href="{{ route('avisar', ['vendedorId' => $vendedor['id']]) }}" class="btn btn-warning">Avisar a {{ $vendedor['nombre'] }}</a>
                                                @endif
                                            @endforeach
                                        @endif
                                    @else
                                        <span class="btn btn-success disabled">En proceso</span>
                                        <a href="{{ route('pedidos.show', ['pedido' => $pedido->id]) }}" class="btn btn-warning">Completar</a>
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

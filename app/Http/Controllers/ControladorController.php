<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Province;


class ControladorController extends Controller
{
    public function index()
    {
        // Obtener los OrderItems relacionados con el vendor
        $orderItems = OrderItem::with('order')->get();

        // Calcular los días restantes para cada pedido
        foreach ($orderItems as $orderItem) {
            $createdDate = Carbon::parse($orderItem->order->created_at);

            // Obtener la diferencia en días entre la fecha de creación y el día actual
            $diferenciaDias = max(0, $createdDate->diffInDays(now()));

            // Formatear la cadena
            $orderItem->dias_restantes = $diferenciaDias;
        }
        // Pasar los OrderItems con los días restantes a la vista
        return view('controlador', ['pedidos' => $orderItems]);
    }

    public function show($orderId)
    {
        $order = Order::with('deliveryAddress.municipio.provincia', 'items.product')->findOrFail($orderId);
        $provincias = Province::all();
        return view('detalle', ['pedido' => $order, 'provincias' => $provincias]);
    }

}

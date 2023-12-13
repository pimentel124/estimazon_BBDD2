<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;



class RepartidorController extends Controller
{
    public function index()
    {
        // Obtener los pedidos con información de productos
        $orders = Order::with('items.product', 'items.vendor')->get();

        // Pasar los pedidos con los días restantes a la vista
        return view('repartiment', ['pedidos' => $orders]);
    }

}

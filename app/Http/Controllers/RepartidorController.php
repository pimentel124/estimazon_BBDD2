<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;



class RepartidorController extends Controller
{
    public function index()
    {
        // Obtener los OrderItems relacionados con el vendor
        $orderItems = OrderItem::with('order')->get();
        // Pasar los OrderItems con los días restantes a la vista
        return view('repartiment', ['pedidos' => $orderItems]);
    }

}

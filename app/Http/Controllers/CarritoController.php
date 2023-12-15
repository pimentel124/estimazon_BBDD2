<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{

    public function index() {
        // Obtener el carrito de la tabla de pedidos con los items cargados antes
        $order = Order::with(['items.product'])
                      ->where('user_id', Auth::user()->id)
                      ->where('status', 'cart')
                      ->first();

        if (!$order) {
            //return and empty cart
            return view('cart', ['order_items' => [] ]);
        }

        return view('cart', ['order_items' => $order->items]);
    }

    public function addToCart($productStockId, $amount = 1){

        $productStock = ProductStock::find($productStockId);

        //find the actual cart of the user (its a table called order with the field status set to cart)
        $order = Order::where('user_id', Auth::user()->id)->where('status', 'cart')->first();

        //if the user doesnt have a cart, create one
        if(!$order){
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->status = 'cart';
            $order->save();
        }
        //create a OrderItem with the productStockId and the amount
        $orderItem = new OrderItem();
        $orderItem->product_id = $productStock->product_id;
        $orderItem->quantity = $amount;
        $orderItem->vendor_id = $productStock->vendor_id;
        $orderItem->order_id = $order->id;
        $orderItem->save();
        return redirect()->route('carrito')->with('success', 'Product added to the cart successfully.');

    }


    public function remove($orderItemId){
        $orderItem = OrderItem::find($orderItemId);

                $orderItem->delete();
                return redirect()->route('carrito')->with('success', 'Product removed from the cart successfully.');



    }

}

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

    /*
    public function index(Request $request)
    {
        $cart = $request->session()->get('carrito', []);

        // Pass the products to the view
        return view('cart', ['products' => $cart]);
    }
    */

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

    /*
    public function add($id, Request $request, $vendor_id = null)
    {
        // Retrieve the product based on the provided $productId
        $product = Product::find($id);

        // Get the current cart from the session
        $cart = $request->session()->get('carrito', []);

        // Check if the product is already in the cart
        $existingProduct = array_filter($cart, function ($item) use ($product) {
            return $item->id === $product->id;
        });

        if (!empty($existingProduct)) {
            // Product is already in the cart, update the quantity in the cart
            $existingProductKey = key($existingProduct);
            $cart[$existingProductKey]->quantity += 1; // Update the quantity as needed
        } else {
            // Product is not in the cart, add it with a quantity of 1
            $product->quantity = 1; // Assuming you have a 'quantity' attribute in your Product model
            $cart[] = $product;
        }

        log($vendor_id);
        // If vendor_id is not null, get the productStock where the vendor_id is the same as the param
        if ($vendor_id !== null) {
            //log to artisan console the vendor_id
            $productStock = $product->productStocks()->where('vendor_id', $vendor_id)->first();
        } else {
            // Get the productStock with the lowest unit_price
            $productStock = $product->productStocks()->orderBy('unit_price')->first();

        }

        if ($productStock) {
            $productStock->increment('amount');
        }

        // Update the session with the modified cart
        $request->session()->put('carrito', $cart);

        return redirect()->back()->with('success', 'Product added to the cart successfully.');
    }
*/
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

    /*
    public function remove(Request $request, $productId)
    {
        // Logic to remove the product from the cart (this logic may vary based on your implementation)
        // For example, you might store cart data in the session or a database

        // Retrieve the product based on the provided $productId
        $product = Product::find($productId);

        // Remove the product from the cart (replace this with your actual logic)
        // For example, you might store cart data in the session
        $cart = $request->session()->get('carrito', []);
        $cart = array_filter($cart, function ($item) use ($product) {
            return $item->id !== $product->id;
        });

        $productStock = $product->productStocks->first();
        if ($productStock) {
            $productStock->increment('amount');
        }

        $request->session()->put('carrito', $cart);

        return redirect()->route('carrito')->with('success', 'Product removed from the cart successfully.');
    }
    */


}

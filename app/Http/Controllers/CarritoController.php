<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('carrito', []);

        // Pass the products to the view
        return view('cart', ['products' => $cart]);
    }

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
            //log to browser console the productStock
            
        }

        if ($productStock) {
            $productStock->increment('amount');
        }

        // Update the session with the modified cart
        $request->session()->put('carrito', $cart);

        return redirect()->back()->with('success', 'Product added to the cart successfully.');
    }

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
}

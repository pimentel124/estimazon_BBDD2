<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CarritoController extends Controller
{
    public function index()
    {
        $products = Product::all();


        // Pass the products to the view
        return view('cart', ['products' => $products]);
    }

    public function addToCart(Request $request, $id, $vendor_id = null)
    {
        // Find the product with the given ID
        $product = Product::find($id);

        // Check if the product exists
        if (!$product) {
            // Redirect back with an error message
            return redirect()->back()->with('error', 'Product not found');
        }

        // Add the product to the cart
        \App\Models\OrderItems::add([
            'id' => $product->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'vendor_id' => $vendor_id ?? $product->vendor_id,
        ]);

        //['order_id', 'product_id', 'quantity', 'vendor_id']

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Product added to cart successfully');
    }
}

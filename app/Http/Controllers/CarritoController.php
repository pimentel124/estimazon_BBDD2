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

    public function add(Request $request, $productId)
    {
        // Logic to add the product to the cart (this logic may vary based on your implementation)
        // For example, you might store cart data in the session or a database

        // Retrieve the product based on the provided $productId
        $product = Product::find($productId);

        // Add the product to the cart (replace this with your actual logic)
        // For example, you might store cart data in the session
        $cart = $request->session()->get('cart', []);
        $cart[] = $product;
        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to the cart successfully.');
    }
}


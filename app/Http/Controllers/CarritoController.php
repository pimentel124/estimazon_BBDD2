<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CarritoController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('carrito', []);

        // Pass the products to the view
        return view('cart', ['products' => $cart]);
    }

    public function add(Request $request, $productId)
    {
        // Retrieve the product based on the provided $productId
        $product = Product::find($productId);

        // Get the current cart from the session
        $cart = $request->session()->get('carrito', []);

        // Add the product to the cart
        $cart[] = $product;

        // Update the session with the modified cart
        $request->session()->put('carrito', $cart);

        return redirect()->back()->with('success', 'Product added to the cart successfully.');
    }

}


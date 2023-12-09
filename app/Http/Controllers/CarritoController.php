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

    // CarritoController.php

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
    $request->session()->put('carrito', $cart);

    return redirect()->route('carrito')->with('success', 'Product removed from the cart successfully.');
}

}


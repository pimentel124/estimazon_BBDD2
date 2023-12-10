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

        $product->productStocks->first()->decrement('amount');

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

    $product = Product::find($productId);
    $product->productStocks->first()->increment('amount');
    $request->session()->put('carrito', $cart);

    return redirect()->route('carrito')->with('success', 'Product removed from the cart successfully.');
}

}


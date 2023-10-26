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
}


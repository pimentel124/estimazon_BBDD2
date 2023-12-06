<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all products from the database and pass them to the view
        $products = DB::table('products as p')
       ->select('p.id as product_id', 'p.name as product_name', 'p.description as product_description', 'p.image_url as image_url', 'ps.unit_price as price', 'ps.vendor_id', 'u.full_name as vendor_name')
       ->join('product_stock as ps', 'p.id', '=', 'ps.product_id')
       ->join('users as u', 'ps.vendor_id', '=', 'u.id')
       ->whereRaw('ps.unit_price = (SELECT MIN(unit_price) FROM product_stock WHERE product_id = p.id)')
       ->get();

       return view('index', ['products' => $products]);

    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Sube la imagen y obtén la ruta
        $imagePath = $request->file('image')->store('uploads', 'public');

        // Crea un nuevo producto y almacena la ruta de la imagen en la base de datos
        $product = new Product([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image_url' => $imagePath, // Almacena la ruta de la imagen en la base de datos
        ]);

        $product->save();

        return redirect()->route('subir_producto')->with('success', 'Producto subido con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('vendor')->findOrFail($id);

        return view('products.show', compact('product'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function myProducts()
{
    $userProducts = auth()->user()->products ?? collect(); // Use the null coalescing operator to handle null

    return view('products.myprods', compact('userProducts'));
}
}

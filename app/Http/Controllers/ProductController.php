<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductStock;
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
        //$products = Product::with('productStocks')->get();

        $products = DB::table('products as p')
            ->select('p.id as id', 'p.name as name', 'p.description as description', 'p.image_url as image_url', 'ps.unit_price as price', 'ps.vendor_id', 'ps.id as product_stockId', 'u.full_name as vendor_name')
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
            'amount' => 'required|numeric',
            'unit_price' => 'required|numeric',
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

        $productStock = new ProductStock([
            'amount' => $request->input('amount'),
            'unit_price' => $request->input('unit_price'),
            'vendor_id' => auth()->id(),
        ]);

        // Save the association between Product and ProductStock
        $product->productStocks()->save($productStock);

        return redirect()->route('subir_producto')->with('success', 'Producto subido con éxito.');
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $product = Product::with(['productStocks' => function ($query) {
            $query->orderBy('unit_price', 'asc')->with('vendor');
        }])->findOrFail($id);
        // Log all the product properties to the console
        //dd($product);

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required',
            'amount' => 'required',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');

        $product->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image_url' => $imagePath,
        ]);

        foreach ($product->productStocks as $productStock) {
            $productStock->update([
                'unit_price' => $request->input('price'),
                'amount' => $request->input('amount'),
            ]);
        }

        return redirect()->route('myprods')->with('success', 'Producto actualizado con éxito.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->productStocks()->delete();

        $product->delete();

        return redirect()->route('myprods')->with('success', 'Producto eliminado con éxito.');
    }


    public function myProducts()
    {
        $vendorId = auth()->id();
        $userProducts = Product::whereHas('productStocks', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->get();

        return view('products.myprods', compact('userProducts'));
    }
}

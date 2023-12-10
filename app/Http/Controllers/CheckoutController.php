<?php

namespace App\Http\Controllers;
use App\Models\Municipio;
use App\Models\Province;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Your logic for the checkout page goes here
        return view('checkout'); // Assuming you have a blade file named checkout.blade.php
    }

    public function showCheckoutForm()
    {
        // Obtén la lista de provincias desde el modelo Province
        $provincias = Province::all(); // Ajusta esto según tu lógica específica

        // Pasa la lista de provincias a la vista
        return view('checkout', ['provincias' => $provincias]);
    }

    // Puedes agregar un método adicional para cargar los municipios en función de la provincia seleccionada
// CheckoutController.php
public function getMunicipiosByProvince($provinceId)
{
    // Lógica para obtener municipios en función de la provincia seleccionada
    $municipios = Municipio::where('idProvince', $provinceId)->get();

    // Devolver la respuesta JSON
    return response()->json($municipios);
}



public function process(Request $request)
{
    // Accede al municipio y dirección
    $municipioId = $request->input('municipio');
    $direccion = $request->input('direccion');

    // Crea un nuevo pedido
    $order = new Order();
    $order->user_id = Auth::id();
    $order->status = 'En proceso'; // O el estado que prefieras
    $order->delivery_address = $direccion;
    $order->save();

    // Obtén el ID del pedido recién creado
    $orderId = $order->id;

    // Puedes acceder al ID del municipio a través de tu lógica de negocio,
    // en este ejemplo asumiré que tienes un campo llamado "municipio_id" en la tabla "order"
    $order->municipio_id = $municipioId;
    $order->save();

    // Guarda los datos en la tabla "order_items"
    $cart = $request->session()->get('carrito', []);

    foreach ($cart as $product) {
        $orderItem = new OrderItem();
        $orderItem->order_id = $orderId;
        $orderItem->product_id = $product->id;
        $orderItem->quantity = 1; // O ajusta según tu lógica
        $orderItem->vendor_id = $product->vendor_id; // Ajusta según tu lógica
        $orderItem->save();
    }

    // Limpia el carrito después de completar el pedido
    $request->session()->forget('carrito');

    // Redirige a la página de confirmación u otro lugar según tu lógica
    return redirect()->route('confirmation')->with('success', 'Pedido realizado con éxito');
}
}

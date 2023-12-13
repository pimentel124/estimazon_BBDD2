<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Province;
use App\Models\ShippingCompany;



class ControladorController extends Controller
{
    public function index()
    {
        // Obtener los pedidos con información de productos
        $orders = Order::with('items.product', 'items.vendor')->get();

        // Calcular los días restantes para cada pedido
        foreach ($orders as $order) {
            $createdDate = Carbon::parse($order->created_at);

            // Obtener la diferencia en días entre la fecha de creación y el día actual
            $diferenciaDias = max(0, $createdDate->diffInDays(now()));

            // Formatear la cadena
            $order->dias_restantes = $diferenciaDias;
        }

        // Pasar los pedidos con los días restantes a la vista
        return view('controlador', ['pedidos' => $orders]);
    }


    public function show($orderId)
    {
        $order = Order::with('deliveryAddress.municipio.provincia', 'items.product')->findOrFail($orderId);
        $provincias = Province::all();
        $empresas = ShippingCompany::all();

        return view('detalle', ['pedido' => $order, 'provincias' => $provincias, 'empresas' => $empresas]);
    }

    public function guardarEnvio($orderId)
    {
        $order = Order::findOrFail($orderId);
        // Validar la solicitud según tus necesidades

        $order->update([
            'status' => 'to_center',
            'shippingcompany' => request('empresa'),
        ]);

        return redirect()->back()->with('success', 'Empresa de envío actualizada correctamente.');
    }

}

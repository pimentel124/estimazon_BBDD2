<?php

namespace App\Http\Controllers;
use App\Models\Municipio;
use App\Models\Province;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;




class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function showCheckoutForm()
    {
        // Obtén la lista de provincias desde el modelo Province
        $provincias = Province::all(); // Ajusta esto según tu lógica específica

        $addresses = Address::where('user_id', Auth::user()->id)->with('municipio')->get();

        // Pasa la lista de provincias a la vista
        return view('checkout', ['provincias' => $provincias, 'addresses' => $addresses]);
    }

    public function getMunicipiosByProvince($provinceId)
    {
        // Lógica para obtener municipios en función de la provincia seleccionada
        $municipios = Municipio::where('idProvince', $provinceId)->get();

        // Devolver la respuesta JSON
        return response()->json($municipios);
    }

    public function process(Request $request)
    {
        $municipioId = $request->input('municipio');
        $direccion = $request->input('direccion');
        $numero = $request->input('numero');
        $piso = $request->input('piso');
        $quantity = $request->input('quantity', 1); // Ajusta según tu lógica

        $adressId = $request->input('address_id', -1);
        // Crea una nueva dirección

        $address = Address::find($adressId);


        if (!$address)  {
            // Crea una nueva dirección
            $address = new Address();
            $address->municipe_id = $municipioId;
            $address->direction = $direccion;
            $address->number = $numero;
            $address->floor = $piso;
            $address->user_id = Auth::user()->id;
            $address->save();
        }


        // Crea una nueva orden y asocia la dirección
        $order = Order::where('user_id', Auth::user()->id)->where('status', 'cart')->first();
        $order->user_id = Auth::user()->id;
        $order->status = 'confirmed';
        $order->delivery_address = $address->id; // Asocia la dirección con la orden
        $order->save();

        // Redirige a la página de confirmación u otro lugar según tu lógica
        return redirect()->route('index')->with('success', 'Pedido realizado con éxito');
    }
}

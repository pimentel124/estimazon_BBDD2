<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\OrderItem;
use App\Models\Incidencia;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        // Obtener el ID del vendor autenticado
        $userId = Auth::id();

        // Obtener los OrderItems relacionados con el vendor
        $orderItems = OrderItem::with('order')->where('vendor_id', $userId)->get();

        // Calcular los días restantes para cada pedido
        foreach ($orderItems as $orderItem) {
            $createdDate = Carbon::parse($orderItem->order->created_at);
            $diasRestantes = $createdDate->addDays(5)->diff(now());

            // Obtener días, horas y minutos restantes
            $dias = $diasRestantes->d;
            $horas = $diasRestantes->h;
            $minutos = $diasRestantes->i;

            // Formatear la cadena
            $tiempoRestante = sprintf('%d días, %d horas, %d minutos', $dias, $horas, $minutos);

            $orderItem->dias_restantes = $tiempoRestante;

        }

        // Pasar los OrderItems con los días restantes a la vista
        return view('pedidos', ['pedidos' => $orderItems]);
    }

    public function enviar(Request $request, $pedidoId)
    {
        // Recuperar el pedido basado en el ID proporcionado
        $pedido = OrderItem::where('order_id', $pedidoId)->firstOrFail();

        // Verificar si el usuario autenticado tiene permiso para enviar este pedido
        $userId = Auth::id();
        if ($pedido->vendor_id !== $userId) {
            // El usuario no tiene permiso para enviar este pedido
            abort(403, 'Unauthorized action.');
        }

        $pedido->order->update(['status' => 'sent']);

        // Puedes realizar cualquier otra lógica necesaria aquí

        // Redirigir de vuelta a la página de pedidos con un mensaje de éxito
        return redirect()->route('pedidos')->with('success', 'Pedido enviado con éxito.');
    }

    public function avisar(Request $request, $vendedorId)
    {
        // Llamar al stored procedure para actualizar el estado del vendedor
        DB::statement('CALL actualizar_estado_vendedor(?)', [$vendedorId]);

        // Puedes devolver una respuesta JSON si es necesario
        return redirect()->route('controlador');
    }

    public function mostrarIncidencia(Order $pedido)
    {
        // Lógica para mostrar la incidencia del pedido
        return view('incidencia', ['pedido' => $pedido]);
    }


    public function almacenarIncidencia(Request $request, Order $pedido)
    {
        // Validación de datos de entrada (puedes personalizar según tus necesidades)
        $request->validate([
            'descripcion' => 'required|string',
        ]);

        // Crear la incidencia
        $incidencia = new Incidencia([
            'description' => $request->input('descripcion'),
            'product_id' => $pedido->items->first()->product_id, // Se asume que tomas el producto del primer item del pedido
            'vendor_id' => $pedido->items->first()->vendor_id, // Se asume que el vendor_id es el mismo que el del pedido
            'controller_id' => auth()->id(), // Se asume que el controlador es el usuario autenticado
        ]);


        // Asociar la incidencia con el pedido
        $pedido->incidences()->save($incidencia);

        // Puedes redirigir a la página de detalles del pedido u otro lugar
        return redirect()->route('repartidor')->with('success', 'Incidencia agregada exitosamente.');
    }

}

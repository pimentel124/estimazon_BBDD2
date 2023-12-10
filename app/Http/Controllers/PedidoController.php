<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\OrderItem;

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
}

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

            // Obtener la diferencia en días entre la fecha de creación y el día actual
            $diferenciaDias = max(0, $createdDate->diffInDays(now()));

            // Formatear la cadena
            $orderItem->dias_restantes = $diferenciaDias;
        }

        // Pasar los OrderItems con los días restantes a la vista
        return view('pedidos', ['pedidos' => $orderItems]);
    }

    public function enviar(Request $request, $pedidoId)
    {
        // Recuperar el pedido basado en el ID proporcionado
        $pedido = OrderItem::where('id', $pedidoId)->firstOrFail();
        // Verificar si el usuario autenticado es un vendedor y tiene permiso para enviar este pedido
        $userId = Auth::id();
        if ($pedido->vendor_id == $userId) {
            // Actualizar el campo "enviado" a true
            $pedido->update(['enviado' => true]);
            $todosEnviados = $pedido->pluck('enviado')->every(function ($enviado) {
                return $enviado == true;
            });
            // Si todos los items están enviados, actualizar el estado del pedido
            if ($todosEnviados) {
                $pedido->order->update(['status' => 'to_center']);
            }
            // Redirigir de vuelta a la página de pedidos con un mensaje de éxito
            return redirect()->route('pedidos')->with('success', 'Pedido enviado con éxito.');
        }
        // Si el usuario no tiene permiso, redirigir con un mensaje de error
        return redirect()->route('pedidos')->with('error', 'No tienes permiso para enviar este pedido.');
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

    public function updateStatus(Request $request, Order $pedido)
    {
        // Validación de datos de entrada (puedes personalizar según tus necesidades)
        $request->validate([
            'status' => 'required|string',
        ]);

        // Asegúrate de que el nuevo estado sea válido
        $nuevoEstado = $request->input('status');
        $estadosValidos = ['cart', 'confirmed', 'to_center', 'delivering', 'recieved', 'alt_recieved', 'refused', 'returned'];
        if (!in_array($nuevoEstado, $estadosValidos)) {
            // Si el nuevo estado no es válido, puedes manejarlo según tus necesidades (por ejemplo, devolver un mensaje de error)
            return back()->with('error', 'Estado no válido');
        }

        // Actualizar el estado del pedido
        $pedido->update(['status' => $nuevoEstado]);

        // Incrementar el número de intentos si el nuevo estado es 'refused'
        if ($nuevoEstado === 'refused') {
            $pedido->increment('tries');

            // Verificar si el número de intentos ha llegado a 3 y cambiar el estado a 'returned'
            if ($pedido->tries >= 3) {
                $pedido->update(['status' => 'returned']);
            }
        }

        // Puedes realizar otras acciones necesarias según el nuevo estado aquí

        // Devolver a la misma página de detalles del pedido con un mensaje de éxito
        return back()->with('success', 'Estado actualizado con éxito.');
    }

}

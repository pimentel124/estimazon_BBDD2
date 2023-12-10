<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\OrderItem;

class ControladorController extends Controller
{
    public function index()
    {
        // Obtener los OrderItems relacionados con el vendor
        $orderItems = OrderItem::with('order')->get();

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
        return view('controlador', ['pedidos' => $orderItems]);
    }

}

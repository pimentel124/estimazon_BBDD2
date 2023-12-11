<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    public $timestamps = false;

    protected $table = 'incidences';

    protected $fillable = [
        'description',
        'order_id',
        'product_id',
        'vendor_id',
        'controller_id',
        'intentos',
    ];

    // Relación con la orden
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relación con el producto
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relación con el vendedor
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    // Relación con el controlador
    public function controller()
    {
        return $this->belongsTo(User::class, 'controller_id');
    }
}

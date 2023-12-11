<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'order_id';
    public $timestamps = false;
    protected $table = 'order_items'; // Nombre correcto de la tabla
    protected $fillable = ['order_id','product_id',	'quantity',	'vendor_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function order()
{
    return $this->belongsTo(Order::class, 'order_id');
}
}


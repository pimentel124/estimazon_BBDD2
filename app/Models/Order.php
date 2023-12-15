<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders'; // Nombre correcto de la tabla
    protected $fillable = ['user_id	','status',	'delivery_address', 'intentos', 'shippingcompany'];

    public function items()
{
    return $this->hasMany(OrderItem::class);
}
public function deliveryAddress()
{
    return $this->belongsTo(Address::class, 'delivery_address');
}

}

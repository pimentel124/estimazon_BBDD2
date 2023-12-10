<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;
    protected $table = 'order_items'; // Nombre correcto de la tabla
    protected $fillable = ['order_id','product_id',	'quantity',	'vendor_id'];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $table = 'orders'; // Nombre correcto de la tabla
    protected $fillable = ['user_id	','status',	'delivery_address'];

}

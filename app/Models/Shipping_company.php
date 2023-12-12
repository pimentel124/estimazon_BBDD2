<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping_company extends Model
{
    protected $table = 'shippingcompany'; // Nombre correcto de la tabla
    protected $fillable = ['name'];
    use HasFactory;

    public function shipping_provinces()
    {
        return $this->hasMany(ShippingProvinces::class, 'shipping_company_id');
    }
}

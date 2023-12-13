<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    protected $table = 'shippingcompany'; // Nombre correcto de la tabla
    protected $fillable = ['name'];

    public function provinces()
    {
        return $this->hasMany(ShippingProvinces::class, 'shipping_company_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingProvinces extends Model
{
    protected $table = 'shipping_provinces'; // Nombre correcto de la tabla

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function shipping_company()
    {
        return $this->belongsTo(Shipping_company::class, 'shipping_company_id');
    }
    use HasFactory;
}

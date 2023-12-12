<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces'; // Nombre correcto de la tabla
    protected $fillable = ['id', 'idCCAA', 'name'];

    // En el modelo Province
public function addresses()
{
    return $this->hasMany(Address::class, 'province_id');
}

public function shipping_provinces()
{
    return $this->hasMany(ShippingProvinces::class, 'province_id');
}
}

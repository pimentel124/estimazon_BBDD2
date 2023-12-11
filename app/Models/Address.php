<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false; // Desactivar marcas de tiempo
    protected $table = 'address'; // Nombre correcto de la tabla
    protected $fillable = ['direction','municipe_id','number','floor'];

    // En el modelo Address
public function municipio()
{
    return $this->belongsTo(Municipio::class, 'municipe_id');
}

public function provincia()
{
    return $this->belongsTo(Province::class, 'province_id');
}

}

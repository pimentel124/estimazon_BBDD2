<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false; // Desactivar marcas de tiempo
    protected $table = 'address'; // Nombre correcto de la tabla
    protected $fillable = ['direction','municipe_id','number','floor'];

}

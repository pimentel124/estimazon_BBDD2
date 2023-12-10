<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipes'; // Nombre correcto de la tabla
    protected $fillable = ['idProvince', 'codMunicipe', 'DC', 'name'];

}

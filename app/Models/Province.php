<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces'; // Nombre correcto de la tabla
    protected $fillable = ['id', 'idCCAA', 'name'];

}

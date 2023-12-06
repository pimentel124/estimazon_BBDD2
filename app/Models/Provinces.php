<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
   protected $fillable = ['idCCAA', 'name'];

   public function ccaa()
   {
       return $this->belongsTo(Ccaa::class, 'idCCAA');
   }

   public function municipes()
   {
       return $this->hasMany(Municipes::class);
   }
}


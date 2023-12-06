<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipes extends Model
{
   protected $fillable = ['idProvince', 'codMunicipe', 'DC', 'name'];

   public function province()
   {
       return $this->belongsTo(Provinces::class, 'idProvince');
   }

   public function address()
   {
       return $this->hasMany(Address::class, 'municipe_id');
   }
}


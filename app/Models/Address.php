<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
   protected $fillable = ['direction', 'municipe_id', 'number', 'floor'];

   public function municipes()
   {
       return $this->belongsTo(Municipes::class, 'municipe_id');
   }
}

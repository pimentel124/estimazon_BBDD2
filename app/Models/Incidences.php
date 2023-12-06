<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidences extends Model
{
   protected $fillable = ['description', 'order_id', 'product_id', 'vendor_id', 'controller_id'];

   public function order()
   {
       return $this->belongsTo(Orders::class, 'order_id');
   }

   public function product()
   {
       return $this->belongsTo(Products::class, 'product_id');
   }

   public function vendor()
   {
       return $this->belongsTo(Users::class, 'vendor_id');
   }

   public function controller()
   {
       return $this->belongsTo(Users::class, 'controller_id');
   }
}

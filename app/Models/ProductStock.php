<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
   protected $fillable = ['amount', 'unit_price', 'product_id', 'vendor_id'];

   public function product()
   {
       return $this->belongsTo(Products::class, 'product_id');
   }

   public function vendor()
   {
       return $this->belongsTo(Users::class, 'vendor_id');
   }
}

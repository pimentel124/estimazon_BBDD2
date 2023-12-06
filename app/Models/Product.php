<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
   protected $fillable = ['name', 'description', 'image_url', 'status', 'category'];

   public function category()
   {
       return $this->belongsTo(Categories::class, 'category');
   }

   public function prductStock()
   {
       return $this->hasMany(ProductStock::class);
   }
}


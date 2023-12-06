<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
   protected $fillable = ['name', 'slug', 'description', 'parent_category'];

   public function parentCategory()
   {
       return $this->belongsTo(Categories::class, 'parent_category');
   }

   public function products()
   {
       return $this->hasMany(Products::class);
   }
}


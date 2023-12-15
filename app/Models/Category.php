<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name'];

    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}

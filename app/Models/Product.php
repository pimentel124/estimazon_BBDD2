<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'image_url'];
    use HasFactory;
    public $timestamps = false; // Disable timestamps for this model

    
    public function vendor()
    {
        return $this->belongsTo(User::class);
    }
    

    public function productStocks()
{
    return $this->hasMany(ProductStock::class);
}
// Product.php (Product model)

public function getPrice()
{
    // Assuming there's a relationship with ProductStock
    $productStock = $this->productStocks()->orderBy('unit_price')->first();

    if ($productStock) {
        $unitPrice = $productStock->unit_price;
        return $unitPrice;
    }
    return 0;
}

}

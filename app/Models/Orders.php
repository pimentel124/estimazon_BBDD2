<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
   protected $fillable = ['user_id', 'status', 'delivery_address'];

   public function user()
   {
       return $this->belongsTo(Users::class, 'user_id');
   }

   public function deliveryAddress()
   {
       return $this->belongsTo(Address::class, 'delivery_address');
   }

   public function orderItems()
   {
       return $this->hasMany(OrderItems::class);
   }
}


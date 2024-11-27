<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'orders_items';
     public function product_order_items()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

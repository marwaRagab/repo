<?php

namespace App\Models;

use App\Models\Showroom\products_items;
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

    public function product_items_order()
    {
        return $this->belongsTo(products_items::class, 'product_items_id');
    }
}

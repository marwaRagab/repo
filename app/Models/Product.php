<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function purchaseOrderItems()
{
    return $this->hasMany(PurchaseOrderItem::class, 'product_id');
}

public function mark()
{
    return $this->belongsTo(Mark::class, 'mark_id'); // `mark_id` is the foreign key in the `products` table
}

public function class()
{
    return $this->belongsTo(Classes::class, 'class_id'); // `class_id` is the foreign key in the `products` table
}
}

<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function order_item()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}

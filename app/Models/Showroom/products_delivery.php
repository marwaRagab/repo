<?php

namespace App\Models\Showroom;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products_delivery extends Model
{
    use HasFactory;
    public function order_files()
    {
        return $this->belongsTo(order_files::class, 'id');
    }
}

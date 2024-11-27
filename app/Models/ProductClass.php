<?php

namespace App\Models;

use App\Models\Showroom\products_items;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name_ar',
        'name_en',
        'created_by',
        'updated_by'
    ];

    public function productsItems()
    {
        return $this->hasMany(products_items::class, 'product_id', 'id');
    }
}

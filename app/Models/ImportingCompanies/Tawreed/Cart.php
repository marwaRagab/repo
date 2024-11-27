<?php

namespace App\Models\ImportingCompanies\Tawreed;

use App\Models\ImportingCompanies\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'product_id',
        'company_id',
        'place',
        'counter',
        'product_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

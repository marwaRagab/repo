<?php

namespace App\Models\ImportingCompanies\Tawreed;

use App\Models\ImportingCompanies\Product;
use App\Models\ImportingCompanies\Tawreed\OrdersFiles;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchase_items extends Model
{
    use HasFactory;
    protected $table = 'purchase_orders_items';

    protected $fillable = ['product_id', 'order_id', 'count', 'counter_received', 'cancel'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function order_file()
    {
        return $this->belongsTo(OrdersFiles::class, 'order_id');
    }
}

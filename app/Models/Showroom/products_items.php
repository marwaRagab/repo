<?php

namespace App\Models\Showroom;

use App\Models\Company;
use App\Models\ImportingCompanies\Product;
use App\Models\ImportingCompanies\Tawreed\OrdersFiles;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products_items extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function ordersFiles()
    {
        return $this->belongsTo(OrdersFiles::class, 'purchase_id');
    }
    // public function items()
    // {
    //     return $this->hasMany(products_items::class, 'product_id');
    // }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function product_items()
    {
        return $this->belongsTo(OrderItem::class, 'product_items_id');
    }
}

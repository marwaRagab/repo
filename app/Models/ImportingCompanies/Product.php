<?php

namespace App\Models\ImportingCompanies;

use App\Models\Company;
use App\Models\Mark;
use App\Models\ProductClass;
use App\Models\Showroom\products_items;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'mark_id',
        'class_id',
        'model',
        'price',
        'net_price',
        'img',
        'number_type',
        'number',
        'created_by',
        'updated_by'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function mark()
    {
        return $this->belongsTo(Mark::class, 'mark_id');
    }

    public function class()
    {
        return $this->belongsTo(ProductClass::class, 'class_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function productsItems()
    {
        return $this->hasMany(products_items::class, 'product_id');
    }
}

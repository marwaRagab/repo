<?php

namespace App\Models\ImportingCompanies\Tawreed;

use App\Models\Company;
use App\Models\Showroom\products_items;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersFiles extends Model
{
    use HasFactory;
    protected $table = 'orders_files';
    protected $fillable = [
        'order_id',
        'company_id',
        'img',
        'amount',
        'status',
        'send_status',
        'sending_user_id',
        'send_date',
        'place',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function items()
    {
        return $this->hasMany(products_items::class, 'purchase_id');
    }
    public function purchase()
    {
        return $this->hasMany(purchase_items::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}

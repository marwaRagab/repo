<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ImportingCompanies\Tawreed\OrdersFiles;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'phone',
        'fax',
        'email',
        'address',
        'store_phone',
        'delegate_name',
        'delegate_phone',
        'delegate_email',
        'delivery',
        'maintenance',
        'sales',
        'active',
        'created_by',
        'updated_by'
    ];

    public function marks()
    {
        return $this->hasMany(Mark::class, 'company_id');
    }

    public function ordersFiles()
    {
        return $this->hasMany(OrdersFiles::class, 'company_id');
    }
}

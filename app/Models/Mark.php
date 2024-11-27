<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'company_id',
        'img',
        'discount',
        'created_by',
        'updated_by'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function products()
{
    return $this->hasMany(Product::class, 'mark_id'); // `mark_id` is the foreign key in the `products` table
}
}

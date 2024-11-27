<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferCart extends Model
{
    use HasFactory;
    protected $table = 'transfer_cart';

    protected $fillable = [
        'product_item_id',
        'product_id',
        'branch_id',
        'model',
        'company_name',
        'number',
        'description',
    ];
}

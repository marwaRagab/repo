<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_account_number',
        'iban'
    ];
}

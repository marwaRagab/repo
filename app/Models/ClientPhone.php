<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'phone_land',
        'phone_work',
        'nearest_phone'
    ];
}

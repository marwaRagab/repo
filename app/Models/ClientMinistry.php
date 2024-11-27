<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientMinistry extends Model
{
    use HasFactory;

    protected $fillable = [
        'ministry_id'
    ];

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientWorking extends Model
{
    use HasFactory;

    public function ministry()
    {
        return $this->belongsTo(Ministry::class, 'ministry_id');
    }
}

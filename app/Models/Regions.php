<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    use HasFactory;

    public function clients()
    {
        return $this->hasMany(Client::class, 'area_id', 'id');
    }

    public function government()
    {
        return $this->belongsTo(Governorate::class,'governorate_id');
    }



}

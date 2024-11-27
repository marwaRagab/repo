<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Police_station extends Model
{
    use HasFactory,SoftDeletes;
    public function region()
    {
        return $this->belongsTo(Region::class,'region_id');
    }

    public function government()
    {
        return $this->belongsTo(Governorate::class,'governorate_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

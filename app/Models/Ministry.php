<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ministry extends Model
{
    use HasFactory,SoftDeletes;

    public function ministryPercentage()
    {
        return $this->hasOne(Ministry_Percentage::class ,'id','ministry_percentage_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

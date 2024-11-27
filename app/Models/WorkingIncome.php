<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkingIncome extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'working_incomes';

    public function ministryPercentage()
    {
        return $this->hasOne(Ministry_Percentage::class ,'id','ministry_percentage_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

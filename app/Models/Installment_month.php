<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment_month extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='installment_months';
    protected $guarded = [];

    public function installment_id()
    {
        return $this->belongsTo(Installment::class,'installment_id','id');
    }

}

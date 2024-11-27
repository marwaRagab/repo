<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eqrars_details extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='eqrars_details';
    protected $guarded = [];

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
    

    
}

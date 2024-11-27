<?php

namespace App\Models\Military_affairs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Military_affairs_settlement extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table ='military_affairs_settlement';

    public function military_affair()
    {
        return $this->belongsTo(Military_affair::class,'military_affairs_id');
    }
    public function settle_month()
    {
        return $this->hasMany(Military_affairs_settlement_month::class, 'settle_id');
    }

}

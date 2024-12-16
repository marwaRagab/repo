<?php

namespace App\Models\Military_affairs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Military_affairs_times_type extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table ='military_affairs_times_type';

    public function militaryAffairsTimes()
    {
        return $this->hasMany(Military_affairs_times::class, 'times_type_id', 'id');
    }
}

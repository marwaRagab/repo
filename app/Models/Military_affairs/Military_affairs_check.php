<?php

namespace App\Models\Military_affairs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Military_affairs_check extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];
    protected $table = 'military_affairs_check';


}

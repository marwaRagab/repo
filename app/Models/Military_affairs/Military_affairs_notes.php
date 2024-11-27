<?php

namespace App\Models\Military_affairs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Military_affairs_notes extends Model
{
    use HasFactory;
    protected $table = 'military_affairs_notes';
    protected $guarded = [];
    /*protected $fillable = [
        'note','type','military_affairs_id','date','img_dir','date_start','date_end'
    ];*/



}

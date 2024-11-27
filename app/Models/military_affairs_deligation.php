<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Military_affairs\Military_affair;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class military_affairs_deligation extends Model
{
    use HasFactory;

    protected $table = 'military_affairs_deligations';

    public function militaryAffair()
{
    return $this->belongsTo(Military_affair::class, 'military_affairs_id');
}

}

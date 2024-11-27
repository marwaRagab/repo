<?php

namespace App\Models\Military_affairs;

use App\Models\Installment;
use App\Models\Military_affairs\Military_affairs_amount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prev_cols_military_affairs extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'prev_cols_military_affairs';

    public function military_old()
    {

        return $this->belongsTo(Military_affair::class, 'military_affairs_id');
    }

}

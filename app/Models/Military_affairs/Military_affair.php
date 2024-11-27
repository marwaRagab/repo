<?php

namespace App\Models\Military_affairs;

use App\Models\Installment;
use App\Models\Military_affairs\Military_affairs_amount;
use App\Models\military_affairs_deligation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Military_affair extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = [];

    public function installment()
    {
        return $this->belongsTo(Installment::class,'installment_id')->with('client');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
     }

    public function notes()
    {
        return $this->hasMany(Military_affairs_notes::class, 'military_affairs_id');
    }





    public function status_all()
    {
        return $this->hasMany(Military_affairs_status::class, 'military_affairs_id');
    }

    public function jalasaat_all()
    {
        return $this->hasMany(Military_affairs_jalasaat::class, 'military_affairs_id');
    }
    public function military_amount()
    {
        return $this->hasMany(Military_affairs_amount::class, 'military_affairs_id');
    }

    public function military_check()
    {
        return $this->hasMany(Military_affairs_check::class, 'military_affairs_id');
    }

    public function militaryAffairsDelegations()
    {
        return $this->hasMany(military_affairs_deligation::class, 'emp_id');
    }

}

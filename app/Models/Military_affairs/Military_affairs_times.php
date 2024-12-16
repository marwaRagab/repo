<?php

namespace App\Models\Military_affairs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Military_affairs_times extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table ='military_affairs_times';

    public function timesType()
    {
        return $this->belongsTo(Military_affairs_times_type::class, 'times_type_id', 'id');
    }

    public function bankType()
    {
        return $this->belongsTo(Military_affairs_stop_bank_type::class, 'times_type_id', 'id');
    }

    public function carType()
    {
        return $this->belongsTo(Military_affairs_stop_car_type::class, 'times_type_id', 'id');
    }

    public function salaryType()
    {
        return $this->belongsTo(Military_affairs_stop_salary_type::class, 'times_type_id', 'id');
    }
    
    public function travelType()
    {
        return $this->belongsTo(military_affairs_stop_travel_type::class, 'times_type_id', 'id');
    }
}

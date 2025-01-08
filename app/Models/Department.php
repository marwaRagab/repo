<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'department';

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function subdepartment()
    {
        return $this->hasMany(SubDepartment::class, 'department_id');
    }
}

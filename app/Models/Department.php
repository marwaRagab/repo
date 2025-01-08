<?php

namespace App\Models;

use App\Models\SubDepartment;
use Illuminate\Database\Eloquent\Model;
use App\Models\TechnicalSupport\Problem;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    protected $table = 'department';

    public function subdepartment()
    {
        return $this->hasMany(SubDepartment::class, 'department_id');
    }

    public function problems()
    {
        return $this->hasMany(Problem::class, 'department_id');
    }
}

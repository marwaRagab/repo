<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use App\Models\TechnicalSupport\Problem;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubDepartment extends Model
{
    use HasFactory;
    protected $table = "sub_department";

    public function department()
    {
        return $this->belongsTo(Department::class, 'id');
    }

    public function problems()
    {
        return $this->hasMany(Problem::class, 'sub_department_id');
    }
}

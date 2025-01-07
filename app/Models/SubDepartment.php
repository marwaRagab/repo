<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model
{
    use HasFactory;
    protected $table = "sub_department";

    public function department()
    {
        return $this->belongsTo(Department::class, 'id');
    }
}

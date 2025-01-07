<?php

namespace App\Models\TechnicalSupport;

use App\Models\Client;
use App\Models\Department;
use App\Models\Installment;
use App\Models\Installment_Client;
use App\Models\SubDepartment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Problem extends Model
{
    use HasFactory;

    protected $table = 'problem_solving';
    protected $fillable = ['installment_id', 'title', 'link', 'descr', 'file', 'read', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function installment()
    {
        return $this->belongsTo(Installment::class, 'installment_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    
}
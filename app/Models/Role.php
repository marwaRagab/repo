<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['name_ar', 'name_en', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, 'role_permissions');
    // }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    public function users() {
        return $this->hasMany(User::class); // or whatever your relationship is
    }
}

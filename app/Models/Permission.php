<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'title_ar',
        'title_en',
        'parent_id',
        'created_by',
        'updated_by',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public function parent()
    {
        return $this->belongsTo(Permission::class ,'parent_id');
    }

    // children

    public function children()
    {
        return $this->hasMany(Permission::class ,'parent_id');
    }

    public function childrenRecursive()
{
    return $this->children()->with('childrenRecursive');
}
}

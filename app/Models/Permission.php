<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'parent_id',
        'created_by',
        'updated_by',
        'guard_name'
    ];

    /**
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($permission) {
            $permission->name = trim($permission->name);
            $permission->name_ar = trim($permission->name_ar);
            $permission->guard_name = $permission->guard_name ?? 'web';

            if (empty($permission->name) || empty($permission->name_ar)) {
                throw new \Exception("❌ لا يمكن إدخال أسماء فارغة.");
            }

            if (Permission::where('name', $permission->name)
                ->orWhere('name_ar', $permission->name_ar)
                ->exists()) {
                throw new \Exception("⚠️ الصلاحية موجودة بالفعل.");
            }
        });

        static::updating(function ($permission) {
            $permission->name = trim($permission->name);
            $permission->name_ar = trim($permission->name_ar);

            if (empty($permission->name) || empty($permission->name_ar)) {
                throw new \Exception("❌ لا يمكن تحديث الصلاحية باسم فارغ.");
            }

            if (Permission::where('id', '!=', $permission->id)
                ->where(function ($query) use ($permission) {
                    $query->where('name', $permission->name)
                          ->orWhere('name_ar', $permission->name_ar);
                })->exists()) {
                throw new \Exception("⚠️ الصلاحية موجودة بالفعل.");
            }
        });
    }

    /**
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    /**
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    /**
     */
    public function children(): HasMany
    {
        return $this->hasMany(Permission::class, 'parent_id')->with('children');
    }

    /**
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }
}
<?php
namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends SpatieRole
{
    use HasFactory;

    protected $fillable = ['name', 'guard_name'];

    // Relationship with users
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    // Relationship with permissions (optional, since Spatie handles this)
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}

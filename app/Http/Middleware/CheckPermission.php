<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions)
    {

        // Get authenticated user
        $user = Auth::user();
    //    $user = User::find($user->id);

       // dd($user->getAllPermissions()  );

        // Get roles
        $roles = $user->getRoleNames();

        // Get permissions
    //    $permissions = $user->getAllPermissions();

        // Get only permission names
        $permissionNames =$user->getAllPermissions()->pluck('name');

      //  dd($roles, $permissionNames);
    
    if ($user && $user->getAllPermissions()->pluck('name')->intersect($permissions)->isNotEmpty()) {
        return $next($request);
    }

        // Redirect to a specific route or show a 403 error
        return redirect()->route('no_permission'); // Ensure this route exists
        // Alternatively, you can abort with a 403 error
        // return abort(403, 'Unauthorized action.');
    }
}
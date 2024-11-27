<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        // dd( $permission);

        $user = Auth::user();
        // dd($user);
        if (!$user) {
            return redirect('/login');
        }

        $role = Role::with(['permissions.parent'])->findOrFail($user->role_id);
        // dd($role->permissions->pluck('parent'));
        if (!$role) {
            abort(403, 'لايسمح لك بالدخول الى هذه الصفحة');
        }

        // $permission_ids = explode(',', $rule_permission->permission_ids);

        // Fetch all permissions that the user has access to based on their role
        $permission_ids = $role->permissions->pluck('id')->toArray(); // Get IDs of the permissions
        $allPermissions = Permission::whereIn('id', $permission_ids)->with('parent')->get();
        // dd($allPermissions);

        // Check if the user has any of the required permissions
        foreach ($allPermissions as $p) {

            // dd($p);
            // dd($p->parent->title_ar);
            $txt = $p->title_ar."_". $p->parent->title_ar;


            if ($txt == $permission) {
                // dd("true");
                return $next($request);
            }

        }

        abort(403, 'لايسمح لك بالدخول الى هذه الصفحة');
    }
}

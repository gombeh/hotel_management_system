<?php

namespace App\Http\Controllers\Admin;

use App\Attributes\Authorize;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    #[Authorize('permissions', 'role')]
    public function index(Role $role)
    {
        $selectedPermissions = $role->permissions->pluck('id')->toArray();
        $allPermissions = Permission::all();

        return inertia("Admin/Role/Permission/List", [
            'role' => RoleResource::make($role),
            'selectedPermissions' => $selectedPermissions,
            'allPermissions' => PermissionResource::collection($allPermissions),
        ]);
    }

    #[Authorize('permissions', 'role')]
    public function update(Request $request, Role $role)
    {
        ['permissions' => $permissions] = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,id',
        ]);

        $role->permissions()->sync($permissions);

        return redirect()->back()->with("message", "Permissions added to role successfully");
    }
}

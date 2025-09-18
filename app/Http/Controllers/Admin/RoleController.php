<?php

namespace App\Http\Controllers\Admin;

use App\Attributes\Authorize;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {
        $roles = Role::all()
                    ->map(fn ($role) => $role->setAttribute('can', [
                        'edit' => auth()->user()->can('update', $role),
                        'delete' => auth()->user()->can('delete', $role),
                    ]));

        $resource = RoleResource::collection($roles);
        return inertia('Admin/Role/List', [
            'roles' => $resource,
            'can' => [
                'createRole' => auth()->user()->can('create', Role::class),
            ]
        ]);
    }

    public function store(Request $request)
    {
       $data = $request->validate([
           'name' => 'required|unique:roles,name',
       ]);

       Role::create($data);

        return redirect()->back()->with('message', 'Role created.');
    }


    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update($data);

        return redirect()->back()->with('message', 'Role updated.');
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('message', 'Role deleted.');
    }

    #[Authorize('permissions', 'role')]
    public function listPermissions()
    {

    }

    #[Authorize('permissions', 'role')]
    public function storePermissions()
    {

    }
}

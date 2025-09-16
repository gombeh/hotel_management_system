<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        $resource = RoleResource::collection($roles);
        return inertia('Admin/Role/List', [
            'roles' => $resource,
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
}

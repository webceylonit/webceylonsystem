<?php

namespace App\Http\Controllers;

use App\Models\Permissions;
use App\Models\Role;
use App\Models\RoleHasPermissions;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        foreach ($roles as $role) {
            $role->permissions = RoleHasPermissions::where('role_id', $role->id)
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->pluck('permissions.name');
        }
        return view('Roles.index', compact('roles'));
    }


    public function create()
    {
        $permissions = Permissions::all();
        return view('Roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|string|max:255',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Create the role
        $role = Role::create([
            'name' => $request->name
        ]);

        foreach ($request->permissions as $permission) {
            RoleHasPermissions::create([
                'role_id' => $role->id,
                'permission_id' => $permission,
            ]);
        }

        return redirect()->route('role.index')->with('success', 'Role created successfully.');
    }





    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permissions::all();
        $rolePermissions = RoleHasPermissions::where('role_id', $role->id)->pluck('permission_id')->toArray();

        return view('Roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        // Remove existing permissions and assign new
        RoleHasPermissions::where('role_id', $role->id)->delete();

        foreach ($request->permissions as $permission) {
            RoleHasPermissions::create([
                'role_id' => $role->id,
                'permission_id' => $permission,
            ]);
        }

        return redirect()->route('role.index')->with('success', 'Role updated successfully.');
    }






    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // Prevent deletion of Super Admin or other protected roles if needed
        if ($role->name === 'Super Admin') {
            return redirect()->route('role.index')->with('error', 'Cannot delete Super Admin role.');
        }

        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role deleted successfully.');
    }
}

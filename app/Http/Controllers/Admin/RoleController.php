<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\RoleHasPermissions;
use App\Models\ModelHasRoles;
use App\Models\User;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->query('name');

        if(isset($name)) {
            $roles = Role::where('name', 'like', '%'.$name.'%')
                ->whereNot('id', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();
        }else {
            $roles = Role::orderBy('id', 'desc')->paginate(10);
        }

        return RoleResource::collection($roles);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $role = Role::create(['name' => $data['name']]);

        return response([
            'message' => 'Role Added'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $role->update(['name' => $data['name']]);

        return response([
            'message' => 'Role updated'
        ], 201);
    }

    public function delete(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Permissions n users associated with role
        $permissions = RoleHasPermissions::where('role_id', $id)->get();
        $userRole = ModelHasRoles::where('role_id', $id)->get();

        // rovoke all permissions associated with role
        if($permissions) {
            foreach($permissions as $permission) {
                $role->revokePermissionTo($permission);
            }
        }

        // revoke all users from role
        if($userRole) {
            foreach($userRole as $ur) {
                $user = User::find($ur->model_id);

                $user->removeRole($role);
            }
        }

        $role->delete();

        return response([
            'message' => 'Role deleted'
        ]);
    }
}

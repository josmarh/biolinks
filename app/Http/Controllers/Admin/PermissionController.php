<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Resources\PermissionResource;
use App\Models\RoleHasPermissions;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->query('name');

        if(isset($name)) {
            $permissions = Permission::where('name', 'like', '%'.$name.'%')
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString();
        }else {
            $permissions = Permission::orderBy('id', 'desc')->paginate(10);
        }

        return PermissionResource::collection($permissions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $permission = Permission::create(['name' => $data['name']]);

        return response([
            'data' => $permission,
            'message' => 'Permission Added'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $permission->update(['name' => $data['name']]);

        return response([
            'data' => new PermissionResource($permission),
            'message' => 'Permission updated'
        ], 201);
    }

    public function delete($id)
    {
        $permission = Permission::findOrFail($id);

        // Permissions n role associated
        $permissions = RoleHasPermissions::where('permission_id', $id)->get();

        // rovoke all permissions associated role
        if($permissions) {
            foreach($permissions as $permission) {
                $role = Role::find($permission->role_id);

                $role->revokePermissionTo($id);
            }
        }
        
        $permission->delete();

        return response([
            'message' => 'Permission deleted'
        ], 204);
    }
}

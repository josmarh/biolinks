<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;

class RolePermissionsController extends Controller
{
    public function rolePermissions(Request $request, $roleId)
    {
        $menus =  DB::select( DB::raw("SELECT p.id, p.name, rp.role_id FROM permissions p
            left join role_has_permissions rp on p.id=rp.permission_id and rp.role_id = '$roleId'
            order by 1") );

        // $user =  DB::select( DB::raw("SELECT p.id, p.name, rp.role_id FROM permissions p
        //     left join role_has_permissions rp on p.id=rp.permission_id and rp.role_id = '$roleId'
        //     where p.id between 10 and 14
        //     order by 1") );

        // $role =  DB::select( DB::raw("SELECT p.id, p.name, rp.role_id FROM permissions p
        //     left join role_has_permissions rp on p.id=rp.permission_id and rp.role_id = '$roleId'
        //     where p.id between 15 and 19
        //     order by 1") );

        return response([
            'data' => [
                'menus' => $menus,
                'user' => [],
                'role' => []
            ]
        ]);
    }

    public function assignPermissionsToRole(Request $request)
    {
        $permissions = $request->permissions;
        $unpermit = $request->unpermit;
        $roleId = $request->roleId;

        $role = Role::findOrFail($roleId);

        if(!empty($unpermit)) {
            foreach($unpermit as $unpermitt){
                $role->revokePermissionTo($unpermitt);
            }
        }

        if(!empty($permissions)) {
            foreach($permissions as $permission){
                $role->givePermissionTo($permission);
            }
        }

        return response([
            'message' => 'Permission Assigned'
        ], 201);
    }
}

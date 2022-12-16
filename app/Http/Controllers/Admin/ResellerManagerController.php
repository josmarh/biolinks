<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\AdminUserResource;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ResellerManagerController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->query('email');
        $user = $request->user();

        if(isset($email)) {
            $users = User::select('users.id','users.name as username', 'users.email as uemail', 'r.name as role','r.id as role_id', 'users.created_at as joined_date','users.active')
                ->leftjoin('model_has_roles as mr','mr.model_id','=','users.id')
                ->leftjoin('roles as r','r.id','=','mr.role_id')
                ->where('users.email','like', '%'.$email.'%')
                ->where('users.created_by', $user->id)
                ->orderBy('users.created_at', 'desc')
                ->paginate(10)
                ->withQueryString();
        }else {
            $users = User::select('users.id','users.name as username', 'users.email as uemail', 'r.name as role','r.id as role_id', 'users.created_at as joined_date','users.active')
                ->leftjoin('model_has_roles as mr','mr.model_id','=','users.id')
                ->leftjoin('roles as r','r.id','=','mr.role_id')
                ->where('users.created_by', $user->id)
                ->orderBy('users.created_at', 'desc')
                ->paginate(10);
        }

        return AdminUserResource::collection($users);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required', 'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ],
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'active' => 1,
            'created_by' => $user->id
        ])->assignRole($request->role);

        return response([
            'message' => 'User Created.'
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();

        if($data['password'] == '') {
            $request->validate([
                'email' => 'required|email|string',
            ]);

            $user->update([
                'name' => $data['name'],
                'email' => $data['email']
            ]);
        }else {
            $request->validate([
                'email' => 'required|email|string',
                'password' => [
                    'required', 'confirmed',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ]
            ]);

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
        }

        if($data['old_role'] != $data['new_role'] 
            && isset($data['old_role'])) {
            $user->removeRole($data['old_role']);
            $user->assignRole($data['new_role']);
        }else{
            $user->assignRole($data['new_role']);
        }

        return response([
            'message' => 'User updated.'
        ], 201);
    }

    public function block(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->type == 1) {
            $message = 'User Unblocked';
        }else {
            $message = 'User Blocked';
        }

        $user->update([
            'active' => $request->type
        ]);

        return response([
            'message' => $message
        ], 201);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Cascade delete project
        

        $currentRole = Role::select('roles.name as name','mr.model_id')
            ->join('model_has_roles as mr','roles.id', '=', 'mr.role_id')
            ->where('mr.model_id', $user->id)
            ->first();

        $user->removeRole($currentRole->name);
        $user->delete();

        return response([
            'message' => 'User Deleted!'
        ]);
    }

    public function resellerRole()
    {
        $roles = Role::whereNot('name', 'Admin')
            ->whereNot('name', 'User')
            ->orderBy('id', 'desc')->get();

        return RoleResource::collection($roles);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\ProjectInvite;
use App\Models\ProjectTeam;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required', 'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'active' => 1,
            'created_by' => 1
        ])->assignRole('User');

        return response([
            'message' => 'Registration successful.'
        ], 201);
    }

    public function registerMember(Request $request, $id)
    {
        $invite = ProjectInvite::where('invite_id', $id)
            ->where('status', 1)
            ->first();

        if(!$invite) {
            return response([
                'error' => 'Invite expired or does not exists'
            ], 422);
        }

        $check = User::where('email', $request->email)->first();

        if(!$check) {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|string',
                'password' => [
                    'required', 'confirmed',
                    Password::min(8)->mixedCase()->numbers()->symbols()
                ]
            ]);
    
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'active' => 1,
                'created_by' => 1
            ])->assignRole('User');
        }else {
            $user = $check;
        }

        // Set invite status to 2 (accepted)
        $invite->update(['status' => 2]);
            
        ProjectTeam::create([
            'project_id' => $invite->project_id,
            'user_id' => $user->id,
            'status' => 1
        ]);

        return response([
            'message' => 'You have joined successfully.'
        ], 201);
    }
}

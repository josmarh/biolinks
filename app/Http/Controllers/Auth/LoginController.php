<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\UserLogin;
use Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => ['required'],
            'remember' => 'boolean'
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if(!Auth::attempt($credentials, $remember)) {
            event(new UserLogin([
                'email' => $credentials['email'],
                'ip' => request()->ip(),
                'status' => 'failed',
                'description' => 'Incorrect credentials'
            ]));

            return response([
                'error' => 'The provided credentials are not correct'
            ], 422);
        }

        $user = Auth::user();
        
        $token = $user->createToken('main')->plainTextToken;

        event(new UserLogin([
            'email' => $credentials['email'],
            'ip' => request()->ip(),
            'status' => 'success',
            'description' => 'Authentication verified successfully'
        ]));

        return response([
            'user' => $user,
            'token' => $token,
            'membership' => $user->getUserRole(),
            'permissions' => $user->getAllPermissionsAttribute(),
        ]);
    }
}

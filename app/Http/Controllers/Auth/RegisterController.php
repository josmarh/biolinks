<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
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
            'is_active' => 1,
            'created_by' => 1
        ]);

        $user->assignRole('User');

        $token = $user->createToken('main')->plainTextToken;

        return response([
            'message' => 'User Created.',
            'user' => $user,
            'token' => $token,
            'permissions' => $user->getAllPermissionsAttribute()
        ], 201);
    }
}

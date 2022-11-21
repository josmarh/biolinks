<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ForgotPasswordNotification;
use App\Models\User;
use App\Models\PasswordResets;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|string|exists:users,email',
        ]);

        $user = User::where('email', $data['email'])->first();
        $rand = rand(111111, 999999);

        $setToken = PasswordResets::create([
            'email' => $data['email'],
            'token' => $rand
        ]);

        if($setToken) {
            $userInfo = [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $rand
            ];

            Notification::send($user, new ForgotPasswordNotification($userInfo));
        }

        return response([
            'message' => 'Verification code has been sent to your email.'
        ], 201);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\PasswordResets;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => [
                'required', 'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        $token = $request->verification_code;

        $user = User::where('email', $data['email'])->first();
        $tokenValid = PasswordResets::where('token', $token)
            ->where('email', $data['email'])
            ->first();
        
        if(!$tokenValid) {
            return response([
                'error' => 'Invalid Code.'
            ], 422);
        }else {
            $now = Carbon::now();
            $expiredTime = Carbon::create($tokenValid->created_at)->add('1 hour');

            if($now > $expiredTime) {
                return response([
                    'error' => 'Verification code has expired.'
                ], 422);
            }else {
                $user->update([
                    'password' => bcrypt($data['password'])
                ]);

                $userInfo = [
                    'name' => $user->name,
                ];
    
                Notification::send($user, new ResetPasswordNotification($userInfo));
            }
        }

        return response([
            'message' => 'Password reset successfully.'
        ]);
    }
}

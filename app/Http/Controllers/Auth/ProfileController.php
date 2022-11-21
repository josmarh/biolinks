<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return response([
            'user' => $user,
            'status' => 'Personal Information Updated.'
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();
        
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'confirm_password' => ['same:new_password']
        ]);

        $user->update(['password' => bcrypt($request->new_password)]);

        return response([
            'user' => $user,
            'status' => 'Password Updated.'
        ]);         
    }
}

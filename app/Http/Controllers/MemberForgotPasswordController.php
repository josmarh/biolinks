<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
use App\Models\Subscriber;
use App\Models\Project;
use App\Models\MembershipBlog;

class MemberForgotPasswordController extends Controller
{
    public function showForgetPasswordForm($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        
        if(!$project) {
            return view('errors.404');
        }

        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $blogSetting = json_decode($blog->main_setting);
        $blogRouteName = $blogSetting->urlPath;

        return view('member-portal.forgetPassword', compact('projectName','project','blog','blogRouteName'));
    }

    public function submitForgetPasswordForm(Request $request, $projectName)
    {
        $request->validate([
            'email' => 'required|email|exists:bl_subscribers',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        Mail::send('member-portal.forgetPasswordMail', ['token' => $token, 'projectName' => $projectName], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($projectName, $token) { 
        $project = Project::where('name', $projectName)->first();
        
        if(!$project) {
            return view('errors.404');
        }

        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $blogSetting = json_decode($blog->main_setting);
        $blogRouteName = $blogSetting->urlPath;

        return view('member-portal.forgetPasswordLink', compact('token','projectName','project','blog','blogRouteName'));
    }

    public function submitResetPasswordForm(Request $request, $projectName)
    {
        $request->validate([
            'email' => 'required|email|exists:bl_subscribers',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email, 
                'token' => $request->token
            ])
            ->first();
        
        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = Subscriber::where('email', $request->email)
            ->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect()->route('member-login', $projectName)->with('success', 'Your password has been changed!');
      }
}

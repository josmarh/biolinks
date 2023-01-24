<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Post;
use App\Models\MembershipBlog;
use App\Models\Subscriber;
use Log;


class MemberAreaController extends Controller
{
    public function index($projectName, $routeName)
    {
        $project = Project::where('name', $projectName)->first();
        
        if(!$project) {
            return view('errors.404');
        }

        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $blogSetting = json_decode($blog->main_setting);
        if($routeName != $blogSetting->urlPath) {
            return view('errors.404');
        }

        $posts = Post::where('project_id', $project->custom_id)
            ->orderBy('id', 'desc')
            ->paginate(15);
        
        return view('member-portal.index', compact('blog','posts','project'));
    }

    public function login($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $blogSetting = json_decode($blog->main_setting);
        $blogRouteName = $blogSetting->urlPath;

        if(!$project) {
            return view('errors.404');
        }

        return view('member-portal.login', compact('projectName','project','blog','blogRouteName'));
    }

    public function loginMember(Request $request, $projectName)
    {
        $project = Project::where('name', $projectName)->first();
  
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'remember' => $request->remember
        ];
        
        if(Auth::guard('subscriber')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $credentials['remember'])) {
            $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
            $blogSetting = json_decode($blog->main_setting);
            $blogRouteName = $blogSetting->urlPath;

            return redirect()->intended('/w/'.$projectName.'/'.$blogRouteName);
        }else {
            return back()->withInput($request->only('email', 'remember'));
        }
    }

    public function register($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $blogSetting = json_decode($blog->main_setting);
        $blogRouteName = $blogSetting->urlPath;
        
        if(!$project) {
            return view('errors.404');
        }

        return view('member-portal.register', compact('projectName','project','blog','blogRouteName'));
    }

    public function registerMember(Request $request, $projectName)
    {
        $project = Project::where('name', $projectName)->first();

        $credentials = $request->validate([
            'email' => 'required|email|string|unique:bl_subscribers,email',
            'password' => ['required'],
        ]);

        Subscriber::create([
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
            'active' => 1,
        ]);

        if(Auth::guard('subscriber')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
            $blogSetting = json_decode($blog->main_setting);
            $blogRouteName = $blogSetting->urlPath;

            return redirect()->route('member-index', [$projectName, $blogRouteName]);
        }

        return back()->withInput($request->only('email'));
    }

    public function logoutMember(Request $request, $projectName)
    {
        Auth::guard('subscriber')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $blogSetting = json_decode($blog->main_setting);
        $blogRouteName = $blogSetting->urlPath;

        return redirect()->route('member-index', [$projectName, $blogRouteName]);
    }

    public function library($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();

        return view('member-portal.library', compact('project','blog'));
    }

    public function account($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $user = Subscriber::find(Auth::guard('subscriber')->user()->id);

        return view('member-portal.account', compact('project','blog','user'));
    }

    public function updateAccount(Request $request, $projectName)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        $user = Subscriber::find(Auth::guard('subscriber')->user()->id);

        if($request->password && $request->old_password) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
        }else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('member-account', $projectName);
    }

    public function orders($projectName)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();

        return view('member-portal.orders', compact('project','blog'));
    }

    public function post($projectName, $slug)
    {
        $project = Project::where('name', $projectName)->first();
        $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
        $post = Post::where('project_id', $project->custom_id)
            ->where('slug', $slug)
            ->first();
        $author = Subscriber::find($post->author);

        if(!$post) {
            return view('errors.404');
        }

        return view('member-portal.post', compact('project','blog','post','author'));
    }
}

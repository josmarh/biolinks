<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\AdminProjectResource;
use DB;

class AdminProjectController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->query('name');
        $email = $request->query('email');

        if(isset($name) && isset($email)) {
            $projects = DB::table('bl_projects as p')
                ->selectRaw('p.name, count(pl.project_id) as links, count(pt.project_id) as collaborators, u.email as owner, p.created_at')
                ->join('bl_project_links as pl', 'p.custom_id', '=', 'pl.project_id')
                ->leftjoin('bl_project_teams as pt', 'p.custom_id', '=', 'pt.project_id')
                ->join('users as u', 'u.id', '=', 'p.user_id')
                ->where('u.email','like', '%'.$email.'%')
                ->where('p.name','like', '%'.$name.'%')
                ->groupBy('p.name', 'owner', 'p.created_at')
                ->paginate(15)
                ->withQueryString();
        }elseif(isset($name)) {
            $projects = DB::table('bl_projects as p')
                ->selectRaw('p.name, count(pl.project_id) as links, count(pt.project_id) as collaborators, u.email as owner, p.created_at')
                ->join('bl_project_links as pl', 'p.custom_id', '=', 'pl.project_id')
                ->leftjoin('bl_project_teams as pt', 'p.custom_id', '=', 'pt.project_id')
                ->join('users as u', 'u.id', '=', 'p.user_id')
                ->where('p.name','like', '%'.$name.'%')
                ->groupBy('p.name', 'owner', 'p.created_at')
                ->paginate(15)
                ->withQueryString();
        }elseif(isset($email)) {
            $projects = DB::table('bl_projects as p')
                ->selectRaw('p.name, count(pl.project_id) as links, count(pt.project_id) as collaborators, u.email as owner, p.created_at')
                ->join('bl_project_links as pl', 'p.custom_id', '=', 'pl.project_id')
                ->leftjoin('bl_project_teams as pt', 'p.custom_id', '=', 'pt.project_id')
                ->join('users as u', 'u.id', '=', 'p.user_id')
                ->where('u.email','like', '%'.$email.'%')
                ->groupBy('p.name', 'owner', 'p.created_at')
                ->paginate(15)
                ->withQueryString();
        }else {
            $projects = DB::table('bl_projects as p')
                ->selectRaw('p.name, count(pl.project_id) as links, count(pt.project_id) as collaborators, u.email as owner, p.created_at')
                ->join('bl_project_links as pl', 'p.custom_id', '=', 'pl.project_id')
                ->leftjoin('bl_project_teams as pt', 'p.custom_id', '=', 'pt.project_id')
                ->join('users as u', 'u.id', '=', 'p.user_id')
                ->groupBy('p.name', 'owner', 'p.created_at')
                ->paginate(15);
        }

        return AdminProjectResource::collection($projects);
    }
}

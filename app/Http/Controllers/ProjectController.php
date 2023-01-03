<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $projects = Project::leftjoin('bl_project_teams as pt','bl_projects.custom_id','=','pt.project_id')
            ->where('bl_projects.user_id', $userId)
            ->orWhere('pt.user_id', $userId)
            ->where('pt.status', 1)
            ->orderBy('bl_projects.id', 'desc')
            ->get();

        return ProjectResource::collection($projects);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string'
        ]);
        $user = $request->user();
        $customId = rand(11111, 99999);

        $project = Project::create([
            'name' => $data['name'],
            'custom_id' => $customId,
            'user_id' => $user->id,
        ]);

        return response([
            'message' => 'Project created.',
            'project' => new ProjectResource($project),
            'status_code' => 201
        ],201);
    }

    public function show($projectId)
    {
        $project = Project::where('custom_id', $projectId)->first();

        return new ProjectResource($project);
    }

    public function update(Request $request, $projectId)
    {
        $project = Project::where('custom_id', $projectId)->first();

        $project->update(['name' => $request->name]);

        return response([
            'message' => 'Project updated.',
            'status_code' => 201
        ],201);
    }

    public function delete($projectId)
    {
        $project = Project::where('custom_id', $projectId)->first();

        return response([
            'message' => 'Project deleted.',
            'status_code' => 204
        ],200);
    }

}

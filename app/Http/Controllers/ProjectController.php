<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $projects = Project::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return ProjectResource::collection($projects);
    }

    public function projectsCollaborate()
    {

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

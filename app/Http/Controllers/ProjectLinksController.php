<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProjectLink;
use App\Http\Resources\ProjectLinkResource;

class ProjectLinksController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->query('pid');
        $projectLink = ProjectLink::where('project_id', $projectId)
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->paginate(7);

        return ProjectLinkResource::collection($projectLink);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'projectId' => 'required|numeric',
            'type' => 'required|string',
        ]);

        $user = $request->user();
        $linkId = $request->linkId; 
        $longUrl = $request->longUrl ?? null;

        $projectLink = ProjectLink::create([
            'project_id' => $data['projectId'],
            'link_id' => $linkId == null ? Str::random(10) : $linkId,
            'type' => $data['type'],
            'long_url' => $longUrl,
            'user_id' => $user->id
        ]);

        return response([
            'message' => 'Link created.',
            'link' => new ProjectLinkResource($projectLink),
            'status_code' => 201
        ],201);
    }

    public function show($linkId)
    {
        $projectLink = ProjectLink::where('link_id', $linkId)->first();

        return new ProjectLinkResource($projectLink);
    }

    public function update()
    {

    }

    public function updateStatus(Request $request, $id)
    {
        $projectLink = ProjectLink::findOrFail($id);

        $data = $request->validate([
            'status' => 'required|string',
        ]);

        $projectLink->update([
            'status' => $data['status']
        ]);

        return response([
            'message' => 'Link status updated.',
            'status_code' => 201
        ], 201);
    }

    public function delete($id)
    {
        $projectLink = ProjectLink::findOrFail($id);

        return response([
            'message' => 'Link deleted.',
            'status_code' => 204
        ],200);
    }

    public function duplicate(Request $request, $id)
    {
        $projectLink = ProjectLink::findOrFail($id);
        $user = $request->user();

        $newProjectLink = ProjectLink::create([
            'project_id' => $projectLink->project_id,
            'link_id' => $projectLink->link_id.'_copy',
            'type' => $projectLink->type,
            'long_url' => $projectLink->long_url,
            'user_id' => $user->id
        ]);

        return response([
            'message' => 'Link duplicated.',
            'link' => new ProjectLinkResource($newProjectLink),
            'status_code' => 201
        ],201);
    }
}

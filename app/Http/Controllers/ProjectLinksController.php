<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ProjectLink;
use App\Models\LinkSetting;
use App\Http\Resources\ProjectLinkResource;
use App\Events\ProjectLinkCreated;

class ProjectLinksController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->query('pid');
        $projectLink = ProjectLink::where('project_id', $projectId)
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate(7);

        return ProjectLinkResource::collection($projectLink);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'link.projectId' => 'required|numeric',
            'link.type' => 'required|string',
        ]);
        
        if($request->link['linkId']) {
            $request->validate([
                'link.linkId' => 'required|string|unique:bl_project_links'
            ]);
        }

        $user = $request->user();
        $linkId = $request->link['linkId']; 
        $longUrl = $request->link['longUrl'] ?? null;
        
        $projectLink = ProjectLink::create([
            'project_id' => $request->link['projectId'],
            'link_id' => $linkId == null ? Str::random(10) : $linkId,
            'type' => $request->link['type'],
            'long_url' => $longUrl,
            'user_id' => $user->id
        ]);

        $link = [
            'linkId' => $projectLink->id,
            'type' => $request->link['type'],
            'settings' => $request->linkSettings,
            'projectId' => $request->link['projectId'],
        ];
        
        event(new ProjectLinkCreated($link));

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

    public function edit($id)
    {
        $projectLink = ProjectLink::findOrFail($id);

        return new ProjectLinkResource($projectLink);
    }

    public function updateBiolink(Request $request, $id)
    {
        $projectLink = ProjectLink::findOrFail($id);

        $projectLink->update([
            'link_id' => $request->linkId,
        ]);
    }

    public function updateLink(Request $request, $id)
    {
        $projectLink = ProjectLink::findOrFail($id);

        $projectLink->update([
            'long_url' => $request->linkTypeUrl,
            'link_id' => $request->linkId,
        ]);
        
        LinkSetting::where('link_id', $id)
            ->update([
                'tempurl_schedule' => $request->tempurl_schedule,
                'tempurl_start_date' => $request->tempurl_start_date,
                'tempurl_end_date' => $request->tempurl_end_date,
                'tempurl_click_limit' => $request->tempurl_click_limit,
                'tempurl_expire_url' => $request->tempurl_expire_url,
                'protection_password' => $request->protection_password,
                'protection_consent_warning' => $request->protection_consent_warning,
                'target_type' => $request->target_type,
                'target_country' => $request->target_country,
                'target_device' => $request->target_device,
                'target_browser_lang' => $request->target_browser_lang,
                'target_os' => $request->target_os
            ]);

        return response([
            'message' => 'Link update.',
            'status_code' => 201
        ],201);
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

        $projectLink->delete();

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

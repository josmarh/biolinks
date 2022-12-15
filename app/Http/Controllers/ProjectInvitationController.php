<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectInvite;
use App\Jobs\ProjectInviteJob;

class ProjectInvitationController extends Controller
{
    public function sendInvitation(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'projectName' => 'required|string',
            'projectId' => 'required|numeric'
        ]);
        $user = $request->user();
        $inviteId = bin2hex(random_bytes(16));

        $invite = ProjectInvite::create([
            'project_id' => $data['projectId'],
            'invitee_name' => $data['name'],
            'invitee_email' => $data['email'],
            'invite_id' => $inviteId,
            'status' => 1,
            'invited_by' => $user->id,
        ]);

        $inviteData = [
            'invitee_email' => $data['email'],
            'invitee_name' => $data['name'],
            'invited_by' => $user->name,
            'project_name' => $data['projectName'],
            'invite_id' => $inviteId,
        ];

        // notify user
        dispatch(new ProjectInviteJob($inviteData))->delay(3);

        return response([
            'message' => 'Invitation sent.',
            'status_code' => 201
        ], 201);
    }

    public function getInvitationInfo($inviteId)
    {
        $invite = ProjectInvite::where('invite_id', $inviteId)->first();

        if(!$invite) {
            return response([
                'error' => 'Invite expired or does not exists'
            ], 422);
        }

        $data = [
            'name' => $invite->invitee_name,
            'email' => $invite->invitee_email
        ];

        return $data;
    }
}

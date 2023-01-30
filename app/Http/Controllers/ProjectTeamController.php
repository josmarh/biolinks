<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\User;
use App\Models\CustomerLead;
use App\Http\Resources\ProjectTeamResource;
use App\Http\Resources\CustomerLeadResource;
use Carbon\Carbon;

class ProjectTeamController extends Controller
{
    public function projectMembers($projectId)
    {
        $owner = Project::selectRaw('u.email, u.name, "owner" as role, bl_projects.user_id as memberUserId')
            ->leftjoin('users as u','bl_projects.user_id','=','u.id')
            ->where('bl_projects.custom_id', $projectId)
            ->first();

        $members = ProjectTeam::selectRaw('u.email as email, u.name as name, "member" as role, bl_project_teams.user_id')
            ->leftjoin('users as u','bl_project_teams.user_id','=','u.id')
            ->where('bl_project_teams.project_id', $projectId)
            ->get();

        $c = ProjectTeamResource::collection($members);
        $c->add($owner);

        return $c;
    }

    public function removeMember(Request $request, $projectId)
    {
        $memberId = $request->query('memberUserId');

        // delete from bl_project_teams, users;
        $projectMember = ProjectTeam::where('project_id', $projectId)
            ->where('user_id', $memberId)
            ->delete();

        // before delete user from users table, check if user is associated to another project
        $projectMemberCheck = ProjectTeam::where('user_id', $memberId)->get();

        if(count($projectMemberCheck) == 0) {
            $user = User::find($memberId);

            if($user) {
                $user->delete();
            }
        }

        return response([
            'message' => 'Member removed'
        ]);
    }

    public function customerLeads($projectId)
    {
        $customers = CustomerLead::where('project_id', $projectId)->paginate(15);

        return CustomerLeadResource::collection($customers);
    }

    public function exportCustomerLeads(Request $request)
    {
        $leadIds = $request->dataExport;
        $leads = CustomerLead::whereIn('id', $leadIds)->get();

        $fileName   = Carbon::now().'.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Email','Name','Status','Orders','Lifetime Value');
        $callback = function() use($leads, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($leads as $task) {
                $row['Email']  = $task->email;
                $row['Name']   = $task->name;
                $row['Status']  = $task->status;
                $row['Orders']  = $task->orders;
                $row['Lifetime Value']  = $task->lifetime_value;


                fputcsv($file, array($row['Email'], $row['Name'], $row['Status'], $row['Orders'], $row['Lifetime Value']));
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 200, $headers);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\ProjectLink;
use App\Models\LeadStat;
use App\Http\Resources\LeadResource;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function dashboardCardSummary(Request $request)
    {
        $user = $request->user();

        $totalVisits = Visitor::join('bl_project_links as pl','pl.id','=','bl_visitors.link_id')
            ->where('pl.user_id', $user->id)
            ->count();
        $totalLinks = ProjectLink::where('user_id', $user->id)->count();
        $totalLeads = LeadStat::join('bl_project_links as pl','pl.id','=','bl_lead_stats.link_id')
            ->where('pl.user_id', $user->id)
            ->count();

        return response([
            'totalVisits' => $totalVisits,
            'totalLinks' => $totalLinks,
            'totalLeads' => $totalLeads
        ]);
    }

    public function projectLinkClicks($projectId)
    {
        $linkClicks = Visitor::selectRaw('date(bl_visitors.created_at) as created, count(distinct bl_visitors.ip) as "unique", count(*) as impression')
            ->leftjoin('bl_project_links as pl','pl.id','=','bl_visitors.link_id')
            ->where('pl.project_id', $projectId)
            ->groupBy('created')
            ->orderBy('created','desc')
            ->limit(15)
            ->get();

        return response([
            'linkClicks' => $linkClicks
        ]);
    }

    public function leads(Request $request, $linkId)
    {
        $projectLink = ProjectLink::findOrFail($linkId);

        $from = $request->query('from');
        $to = $request->query('to');

        $leads = LeadStat::where('link_id', $linkId)
            ->whereBetween('created_at', [$from, $to])
            ->paginate(15)
            ->withQueryString();

        return LeadResource::collection($leads);
    }

    public function totalLeads($linkId)
    {
        $leads = LeadStat::where('link_id', $linkId)->count();

        return response(['totalLeads' => $leads]);
    }

    public function pageView(Request $request, $linkId)
    {
        $projectLink = ProjectLink::findOrFail($linkId);

        $from = $request->query('from');
        $to = $request->query('to');

        $linkClicks = Visitor::selectRaw('date(bl_visitors.created_at) as created, count(distinct bl_visitors.ip) as "unique", count(*) as impression')
            ->leftjoin('bl_project_links as pl','pl.id','=','bl_visitors.link_id')
            ->where('pl.project_id', $projectLink->project_id)
            ->where('pl.id', $linkId)
            ->whereBetween('bl_visitors.created_at', [$from, $to])
            ->groupBy('created')
            ->orderBy('created','desc')
            ->limit(15)
            ->get();
        
        return response([
            'linkClicks' => $linkClicks
        ]);
    }

    public function exportLeads(Request $request)
    {
        $leadIds = $request->dataExport;
        $leads = LeadStat::whereIn('id', $leadIds)->get();

        $fileName   = Carbon::now().'.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Email','Name','Phone','Create Date');
        $callback = function() use($leads, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($leads as $task) {
                $row['Email']  = $task->email;
                $row['Name']   = $task->name;
                $row['Phone']  = (string) $task->phone;
                $row['Create Date']  = $task->created_at->format('Y-m-d');


                fputcsv($file, array($row['Email'], $row['Name'], $row['Phone'], $row['Create Date']));
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 200, $headers);
    }
}

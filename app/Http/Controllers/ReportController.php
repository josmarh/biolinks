<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\ProjectLink;
use App\Models\LeadStat;
use App\Http\Resources\LeadResource;

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

    public function pageView(Request $request, $linkId)
    {

    }
}

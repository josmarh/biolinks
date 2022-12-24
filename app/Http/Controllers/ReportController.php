<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\ProjectLink;
use App\Models\LeadStat;

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
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectLink;
use App\Http\Resources\AdminProjectLinkResource;

class AdminProjectLinkController extends Controller
{
    public function index(Request $request)
    {
        $linkId = $request->query('linkId');
        $type = $request->query('type');

        if(isset($linkId) && isset($type)) {
            $projectLink = ProjectLink::where('link_id','like', '%'.$linkId.'%')
                ->where('type',$type)
                ->orderBy('id', 'desc')
                ->with('user')
                ->with('project')
                ->paginate(15)
                ->withQueryString();
        }elseif(isset($linkId)) {
            $projectLink = ProjectLink::where('link_id','like', '%'.$linkId.'%')
                ->orderBy('id', 'desc')
                ->with('user')
                ->with('project')
                ->paginate(15)
                ->withQueryString();
        }elseif(isset($type)) {
            $projectLink = ProjectLink::where('type', $type)
                ->orderBy('id', 'desc')
                ->with('user')
                ->with('project')
                ->paginate(15)
                ->withQueryString();
        }else {
            $projectLink = ProjectLink::orderBy('id', 'desc')
                ->with('user')
                ->with('project')
                ->paginate(15);
        }

        return AdminProjectLinkResource::collection($projectLink);
    }
}

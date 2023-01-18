<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Http\Resources\PlanResource;

class PlanController extends Controller
{
    public function index(Request $request, $projectId)
    {
        $title = $request->query('title');

        if(isset($title)) {
            $posts = Plan::where('project_id', $projectId)
                ->where('title', 'like', '%'.$title.'%')
                ->orderBy('id', 'desc')
                ->paginate(15);
        }else {
            $posts = Plan::where('project_id', $projectId)
                ->orderBy('id', 'desc')
                ->paginate(15);
        }

        return PlanResource::collection($posts);
    }

    public function store(Request $request)
    {
        $plan = Plan::create([
            'project_id' => $request->projectId,
            'title' => $request->title,
            'description' => $request->description,
            'unlock_type' => $request->unlockType,
            'monthly_pricing' => $request->monthlyPricing,
            'monthly_price' => $request->monthlyPrice,
            'annual_pricing' => $request->annualPricing,
            'annual_price' => $request->annualPrice,
            'action' => $request->action,
        ]);

        return response([
            'message' => 'Plan created.',
            'planId' => $plan->id,
            'status_code' => 201
        ], 201);
    }

    public function show($id)
    {
        $plan = Plan::findOrFail($id);

        return new PlanResource($plan);
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $plan->update([
            'title' => $request->title,
            'description' => $request->description,
            'unlock_type' => $request->unlockType,
            'monthly_pricing' => $request->monthlyPricing,
            'monthly_price' => $request->monthlyPrice,
            'annual_pricing' => $request->annualPricing,
            'annual_price' => $request->annualPrice,
            'action' => $request->action,
        ]);

        return response([
            'message' => 'Plan Updated.',
            'data' => new PlanResource($plan)
        ]);
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);

        $plan->delete();

        return response([
            'message' => 'Plan deleted.',
            'status_code' => 204
        ]);
    }
}

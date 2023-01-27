<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipBlog;
use App\Models\Order;
use App\Http\Resources\MembershipBlogResource;
use App\Http\Resources\SubscriberResource;

class MembershipBlogController extends Controller
{
    public function show($projectId)
    {
        $blog = MembershipBlog::where('project_id', $projectId)->first();

        if($blog) {
            $blog = new MembershipBlogResource($blog);
        }else {
            $blog = ['data' => (Object)[]];
        }

        return $blog;
    }

    public function store(Request $request)
    {
        // Check if data exists update
        // Else create
        $blog = MembershipBlog::where('project_id', $request->projectId)->first();

        if($blog) {
            $blog->update([
                'headline_color' => $request->headlineColor,
                'text_color' => $request->textColor,
                'bg_color' => $request->bgColor,
                'button_color' => $request->btnColor,
                'link_color' => $request->linkColor,
                'post_bg_color' => $request->postBgColor,
                'title' => $request->title,
                'sub_heading' => $request->subHeading,
                'disclaimer' => $request->disclaimer,
                'header_font_family' => $request->headerFontFamily,
                'text_font_family' => $request->textFontFamily,
                'posts' => $request->posts,
                'subsscriber_alert' => $request->subsscriberAlert,
                'subsscriber_alert_color' => $request->subsscriberAlertColor,
                'emailbox' => $request->emailbox,
                'post_gated_content' => $request->postGatedContent,
                'main_setting' => $request->mainSetting,
                'smedia' => $request->smedia,
            ]);
        }else {
            $blog = MembershipBlog::create([
                'project_id' => $request->projectId,
                'headline_color' => $request->headlineColor,
                'text_color' => $request->textColor,
                'bg_color' => $request->bgColor,
                'button_color' => $request->btnColor,
                'link_color' => $request->linkColor,
                'post_bg_color' => $request->postBgColor,
                'title' => $request->title,
                'sub_heading' => $request->subHeading,
                'disclaimer' => $request->disclaimer,
                'header_font_family' => $request->headerFontFamily,
                'text_font_family' => $request->textFontFamily,
                'posts' => $request->posts,
                'subsscriber_alert' => $request->subsscriberAlert,
                'subsscriber_alert_color' => $request->subsscriberAlertColor,
                'emailbox' => $request->emailbox,
                'post_gated_content' => $request->postGatedContent,
                'main_setting' => $request->mainSetting,
                'smedia' => $request->smedia,
            ]);
        }

        return response([
            'data' => new MembershipBlogResource($blog),
            'message' => 'Blog updated.'
        ]);
    }

    public function subscribers($projectId)
    {
        $subscribers = Order::selectRaw('distinct email')
            ->where('project_id', $projectId)
            ->where('product_source', 'member_product')
            ->where('status', 'success')
            ->paginate(15);

        return SubscriberResource::collection($subscribers);
    }

    public function removeSubscriberAccess(Request $request)
    {
        $projectId = $request->projectId;
        $subscriber = $request->subscriber;

        $subs = Order::where('project_id', $projectId)
            ->where('product_source', 'member_product')
            ->where('status', 'success')
            ->where('email', $subscriber)
            ->get();

        foreach($subs as $sub) {
            $sub->update([
                'status' => 'access_revoked'
            ]);
        }

        return response([
            'message' => 'Access Removed'
        ]);
    }
}

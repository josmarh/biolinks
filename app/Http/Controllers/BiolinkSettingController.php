<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiolinkSetting;
use App\Models\BiolinkCustomSetting;
use App\Http\Resources\BiolinkCustomSettingResource;
use App\Http\Resources\BiolinkSettingResource;
use App\Events\LinkSettings;

class BiolinkSettingController extends Controller
{
    public function index($id)
    {
        $linkSettings = BiolinkSetting::where('link_id', $id)->first();

        return new BiolinkSettingResource($linkSettings);
    }

    public function updateSettings(Request $request, $id)
    {
        $linkSettings = BiolinkSetting::where('link_id', $id)->first();

        $settings = json_decode($request->linkSettings);

        $linkSettings->update([
            'top_logo' => $settings->topLogo,
            'video' => json_encode($settings->video),
            'title' => $settings->title,
            'text_color' => $settings->textColor,
            'verified_checkmark' => $settings->verifiedCheckmark,
            'description' => $settings->description,
            'background_type' => $settings->bckgdType,
            'background_type_content' => json_encode($settings->bckgd),
            'branding' => json_encode($settings->branding),
            'analytics' => json_encode($settings->analytics),
            'seo' => json_encode($settings->seo),
            'utm' => json_encode($settings->utmParams),
            'socials' => json_encode($settings->socials),
            'font' => $settings->fonts,
        ]);

        $projectLink = $request->link;

        event(new LinkSettings($projectLink));

        return response([
            'message' => 'Biolink update.',
            'data' => new BiolinkSettingResource($linkSettings),
            'status_code' => 201
        ], 201);
    }

    public function getCustomSettings($id)
    {
        $linkSettings = BiolinkCustomSetting::where('link_id', $id)->first();

        return new BiolinkCustomSettingResource($linkSettings);
    }

    public function updateCustomSettings(Request $request, $id)
    {
        $linkSettings = BiolinkCustomSetting::where('link_id', $id)->first();

        $linkSettings->update([
            'header_script' => $request->headerScript,
            'footer_script' => $request->footerScript
        ]);

        return response([
            'message' => 'Biolink update.',
            'data' => new BiolinkCustomSettingResource($linkSettings),
            'status_code' => 201
        ], 201);
    }
}

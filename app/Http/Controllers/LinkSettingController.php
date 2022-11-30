<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkSetting;
use App\Models\BiolinkCustomSetting;
use App\Http\Resources\LinkSettingResource;
use App\Http\Resources\BiolinkCustomSettingResource;

class LinkSettingController extends Controller
{
    public function index($id)
    {
        $linkSettings = LinkSetting::where('link_id', $id)->first();

        return new LinkSettingResource($linkSettings);
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiolinkSetting;
use App\Models\BiolinkCustomSetting;
use App\Http\Resources\BiolinkCustomSettingResource;
use App\Http\Resources\BiolinkSettingResource;
use App\Events\LinkSettings;
use App\Services\FileHandler;

class BiolinkSettingController extends Controller
{
    use FileHandler;

    public function index($id)
    {
        $linkSettings = BiolinkSetting::where('link_id', $id)->first();

        return new BiolinkSettingResource($linkSettings);
    }

    public function updateSettings(Request $request, $id)
    {
        $linkSettings = BiolinkSetting::where('link_id', $id)->first();

        $settings = json_decode($request->linkSettings);
        $bgImage = json_decode($linkSettings->background_type_content);
        $favicon = json_decode($linkSettings->seo);

        if(str_contains($settings->topLogo, 'base64')) {
            $settings->topLogo = $this->saveFile('biolink-uploads', $settings->topLogo);
            $this->deleteFile($linkSettings->top_logo);
        }elseif(!$settings->topLogo) {
            $this->deleteFile($linkSettings->top_logo);
        }

        if($settings->bckgdType == 'image' 
            && str_contains($settings->bckgd->image, 'base64')) {
            $settings->bckgd->image = $this->saveFile('biolink-uploads', $settings->bckgd->image);
            $this->deleteFile($bgImage->image);
        }elseif($settings->bckgdType == 'image' && !$settings->bckgd->image) {
            $this->deleteFile($bgImage->image);
        }

        if(str_contains($settings->seo->favicon, 'base64')) {
            $settings->seo->favicon = $this->saveFile('biolink-uploads', $settings->seo->favicon);
            $this->deleteFile($favicon->favicon);
        }elseif(!$settings->seo->favicon) {
            $this->deleteFile($favicon->favicon);
        }

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

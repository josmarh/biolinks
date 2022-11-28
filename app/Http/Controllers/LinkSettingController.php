<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkSetting;
use App\Http\Resources\LinkSettingResource;

class LinkSettingController extends Controller
{
    public function index($id)
    {
        $linkSettings = LinkSetting::where('link_id', $id)->first();

        return new LinkSettingResource($linkSettings);
    }
}

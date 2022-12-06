<?php

namespace App\Http\Controllers;

use App\Models\BiolinkSectionSetting;
use Illuminate\Http\Request;
use App\Events\BioLinkSectionCreated;
use App\Models\BioLinkSection;
use App\Http\Resources\BiolinkSectionResource;

class BiolinkSectionController extends Controller
{
    public function index(Request $request, $id)
    {
        $section = BioLinkSection::where('link_id', $id)->with('section')->get();

        return BiolinkSectionResource::collection($section);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $sectionSetting = BiolinkSectionSetting::create([
            'link_id' => $data['linkId'],
            'section_name' => $data['sectionName']
        ]);

        $section = [
            'sectionId' => $sectionSetting->id,
            'sectionSetting' => $data
        ];

        event(new BioLinkSectionCreated($section));

        return response([
            'message' => 'Section added.',
            'status_code' => 201
        ], 201);
    }

    public function show($id)
    {
        $section = BioLinkSection::findOrFail($id);

        return new BiolinkSectionResource($section);
    }

    public function update(Request $request, $id)
    {
        $section = BioLinkSection::findOrFail($id);

        $section->update([
            'button_text' => $request->buttonText,
            'button_text_color' => $request->buttonTextColor,
            'button_bg_color' => $request->buttonBgColor,
            'core_section_fields' => $request->sectionFields,
        ]);

        return response([
            'message' => 'Section updated.',
            'data' => new BiolinkSectionResource($section),
            'status_code' => 201
        ], 201);
    }

    public function delete($id)
    {
        $section = BioLinkSection::findOrFail($id);

        

        return response([
            'message' => 'Section deleted.',
            'status_code' => 204
        ], 200);
    }
}

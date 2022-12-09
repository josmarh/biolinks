<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiolinkSectionSetting;
use App\Models\BioLinkSection;
use App\Http\Resources\BiolinkSectionResource;
use App\Events\BioLinkSectionCreated;
use App\Services\FileHandler;

class BiolinkSectionController extends Controller
{
    use FileHandler;

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
            'sectionName' => $sectionSetting->section_name,
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
        $settings = BiolinkSectionSetting::find($section->section_id);
        $sectionCustomFields = $request->sectionFields;

        if($settings->section_name == 'Facebook Group') {
            $sectionFields = json_decode($sectionCustomFields);
            $existingImage = json_decode($section->core_section_fields);

            if($sectionFields->type == 'image' 
                && str_contains($sectionFields->typeContentImage, 'base64')) {
                $sectionFields->typeContentImage = $this->saveFile('biolink-uploads', $sectionFields->typeContentImage);
                $this->deleteFile($existingImage->typeContentImage);
            }elseif($sectionFields->type == 'image' && !$sectionFields->typeContentImage) {
                $this->deleteFile($existingImage->typeContentImage);
            }
            $sectionCustomFields = json_encode($sectionFields);
        }

        $section->update([
            'button_text' => $request->buttonText,
            'button_text_color' => $request->buttonTextColor,
            'button_bg_color' => $request->buttonBgColor,
            'core_section_fields' => $sectionCustomFields,
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

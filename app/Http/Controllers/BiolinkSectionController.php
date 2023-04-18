<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiolinkSectionSetting;
use App\Models\BiolinkSection;
use App\Http\Resources\BiolinkSectionResource;
use App\Events\BioLinkSectionCreated;
use App\Services\FileHandler;

class BiolinkSectionController extends Controller
{
    use FileHandler;

    public function index(Request $request, $id)
    {
        $section = BiolinkSection::select('bl_biolink_sections.id','bl_biolink_sections.link_id','bl_biolink_sections.section_id','bl_biolink_sections.button_text','bl_biolink_sections.button_text_color','bl_biolink_sections.button_bg_color','bl_biolink_sections.core_section_fields')
            ->where('bl_biolink_sections.link_id', $id)
            ->join('bl_biolink_section_settings as sect','bl_biolink_sections.section_id','=','sect.id')
            ->with('section')
            ->orderBy('sect.section_position','asc')
            ->get();

        return BiolinkSectionResource::collection($section);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $sectionSetting = BiolinkSectionSetting::create([
            'link_id' => $data['linkId'],
            'section_name' => $data['sectionName'],
            'status' => 1
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
        $section = BiolinkSection::findOrFail($id);

        return new BiolinkSectionResource($section);
    }

    public function update(Request $request, $id)
    {
        $section = BiolinkSection::findOrFail($id);
        $settings = BiolinkSectionSetting::find($section->section_id);
        $sectionCustomFields = $request->sectionFields;

        if($settings->section_name == 'Facebook Group' 
            || $settings->section_name == 'Text Block'
            || $settings->section_name == 'WhatsApp') {
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

        if($settings->section_name == 'Product/Membership' 
        || $settings->section_name == 'Fan Request'
        || $settings->section_name == 'Donation') {
            $sectionFields = json_decode($sectionCustomFields);
            $existingImage = json_decode($section->core_section_fields);

            if(str_contains($sectionFields->thumbnail, 'base64')) {
                $sectionFields->thumbnail = $this->saveFile('biolink-uploads', $sectionFields->thumbnail);
                $this->deleteFile($existingImage->thumbnail);
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
        $section = BiolinkSection::findOrFail($id);

        // delete section, settings
        BiolinkSectionSetting::where('id', $section->section_id)->delete();

        $section->delete();

        return response([
            'message' => 'Section deleted.',
            'status_code' => 204
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $status = BiolinkSectionSetting::find($id);

        $status->update(['status' => $request->status]);

        return response([
            'message' => 'Status updated.',
            'data' => new BiolinkSectionResource($status),
            'status_code' => 201
        ], 201);
    }

    public function updateSectionPosition(Request $request)
    {
        $data = json_decode($request->position);

        foreach($data as $pos) {
            BiolinkSectionSetting::where('link_id', $request->linkId)
                ->where('id', $pos->id)
                ->update(['section_position' => $pos->pos]);
        }

        return response(['success' => true]);
    }
}

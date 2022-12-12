<?php

namespace App\Listeners;

use App\Events\BioLinkSectionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\BiolinkSection;
use App\Services\FileHandler;

class createBiolinkSection
{
    use FileHandler;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BioLinkSectionCreated  $event
     * @return void
     */ 
    public function handle(BioLinkSectionCreated $event)
    {
        $section = $event->section;

        if($section['sectionName'] == 'Facebook Group' 
            || $section['sectionName'] == 'Text Block'
            || $section['sectionName'] == 'WhatsApp') {
            $sectionFields = json_decode($section['sectionSetting']['sectionFields']);

            if($sectionFields->type == 'image' 
                && str_contains($sectionFields->typeContentImage, 'base64')) {
                $sectionFields->typeContentImage = $this->saveFile('biolink-uploads', $sectionFields->typeContentImage);
                $section['sectionSetting']['sectionFields'] = json_encode($sectionFields);
            }
        }

        BiolinkSection::create([
            'link_id' => $section['sectionSetting']['linkId'],
            'section_id' => $section['sectionId'],
            'button_text' => $section['sectionSetting']['buttonText'],
            'button_text_color' => $section['sectionSetting']['buttonTextColor'],
            'button_bg_color' => $section['sectionSetting']['buttonBckgColor'],
            'core_section_fields' => $section['sectionSetting']['sectionFields'],
        ]);
    }
}

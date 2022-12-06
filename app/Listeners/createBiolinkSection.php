<?php

namespace App\Listeners;

use App\Events\BioLinkSectionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\BiolinkSection;

class createBiolinkSection
{
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

        BiolinkSection::create([
            'link_id' => $section['sectionSetting']['linkId'],
            'section_id' => $section['sectionId'],
            'button_text' => $section['sectionSetting']['buttonText'],
            'button_text_color' => $section['sectionSetting']['buttonTextColor'],
            'button_bg_color' => $section['sectionSetting']['buttonBckgColor'],
            'core_section_fields' => $section['sectionSetting']['leadGenField'],
        ]);
    }
}

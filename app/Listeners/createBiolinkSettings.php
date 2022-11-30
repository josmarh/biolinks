<?php

namespace App\Listeners;

use App\Events\ProjectLinkCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\BiolinkSetting;

class createBiolinkSettings
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
     * @param  \App\Events\ProjectLinkCreated  $event
     * @return void
     */
    public function handle(ProjectLinkCreated $event)
    {
        $projectLink = $event->link;

        if($projectLink['type'] == 'biolink') {
            $settings = json_decode($projectLink['settings']);

            BiolinkSetting::create([
                'link_id' => $projectLink['linkId'],
                'top_logo' => $settings->topLogo,
                'video' => json_encode($settings->video),
                'title' => $settings->title,
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
        }
    }
}

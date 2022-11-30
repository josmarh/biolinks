<?php

namespace App\Listeners;

use App\Events\ProjectLinkCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LinkSetting;

class createLinkSettings
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

        if($projectLink['type'] == 'link') {
            $settings = json_decode($projectLink['settings']);

            LinkSetting::create([
                'link_id' => $projectLink['linkId'],
                'tempurl_schedule' => $settings->tempURL->scheduleSwitch,
                'tempurl_start_date' => $settings->tempURL->scheduleStart,
                'tempurl_end_date' => $settings->tempURL->scheduleEnd,
                'tempurl_click_limit' => $settings->tempURL->clickLimit,
                'tempurl_expire_url' => $settings->tempURL->redirectURL,
                'protection_password' => $settings->protection->password,
                'protection_consent_warning' => $settings->protection->contentWarning,
                'target_type' => $settings->target->targetType,
                'target_country' => $settings->target->country,
                'target_device' => $settings->target->device,
                'target_browser_lang' => $settings->target->browserLang,
                'target_os' => $settings->target->os
            ]);
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\ProjectLinkCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LinkSetting;
use App\Models\ProjectLink;
use App\Models\Project;

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
            $settings = json_decode($projectLink['settings'], true);

            LinkSetting::create([
                'link_id' => $projectLink['linkId'],
                'tempurl_schedule' => $settings['tempURL']['scheduleSwitch'],
                'tempurl_start_date' => $settings['tempURL']['scheduleStart'],
                'tempurl_end_date' => $settings['tempURL']['scheduleEnd'],
                'tempurl_click_limit' => $settings['tempURL']['clickLimit'],
                'tempurl_expire_url' => $settings['tempURL']['redirectURL'],
                'protection_password' => $settings['protection']['password'],
                'protection_consent_warning' => $settings['protection']['contentWarning'],
                'target_type' => $settings['target']['targetType'],
                'target_country' => json_encode($settings['target']['country']),
                'target_device' => json_encode($settings['target']['device']),
                'target_browser_lang' => json_encode($settings['target']['browserLang']),
                'target_os' => json_encode($settings['target']['os'])
            ]);

            $totalLinks = ProjectLink::where('project_id', $projectLink['projectId'])->count();
            Project::where('custom_id', $projectLink['projectId'])
                ->update(['total_links' => $totalLinks]);
        }
    }
}

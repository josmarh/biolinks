<?php

namespace App\Observers;

use App\Models\ProjectLink;
use App\Models\LinkSetting;
use App\Models\BiolinkSetting;
use App\Models\BiolinkCustomSetting;
use App\Models\BiolinkSectionSetting;

class ProjectLinkObserver
{
    /**
     * Handle the ProjectLink "created" event.
     *
     * @param  \App\Models\ProjectLink  $projectLink
     * @return void
     */
    public function created(ProjectLink $projectLink)
    {
        if($projectLink->type === 'biolink') {
            BiolinkCustomSetting::create([
                'link_id' => $projectLink->id
            ]);
        }
    }

    /**
     * Handle the ProjectLink "updated" event.
     *
     * @param  \App\Models\ProjectLink  $projectLink
     * @return void
     */
    public function updated(ProjectLink $projectLink)
    {
        //
    }

    /**
     * Handle the ProjectLink "deleted" event.
     *
     * @param  \App\Models\ProjectLink  $projectLink
     * @return void
     */
    public function deleting(ProjectLink $projectLink)
    {
        if($projectLink->type === 'link') {
            LinkSetting::where('link_id', $projectLink->id)->delete();
        }else {
            BiolinkSetting::where('link_id', $projectLink->id)->delete();
            BiolinkCustomSetting::where('link_id', $projectLink->id)->delete();
            BiolinkSectionSetting::where('link_id', $projectLink->id)->delete();
        }
    }

    /**
     * Handle the ProjectLink "restored" event.
     *
     * @param  \App\Models\ProjectLink  $projectLink
     * @return void
     */
    public function restored(ProjectLink $projectLink)
    {
        //
    }

    /**
     * Handle the ProjectLink "force deleted" event.
     *
     * @param  \App\Models\ProjectLink  $projectLink
     * @return void
     */
    public function forceDeleted(ProjectLink $projectLink)
    {
        //
    }
}

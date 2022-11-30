<?php

namespace App\Observers;

use App\Models\ProjectLink;
use App\Models\LinkSetting;
use App\Models\BiolinkSetting;

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
        if($projectLink->type === 'link') {
            LinkSetting::create([
                'link_id' => $projectLink->id
            ]);
        }else {
            // BiolinkSetting::create([
            //     'link_id' => $projectLink->id
            // ]);
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
            $linkSettings = LinkSetting::where('link_id', $projectLink->id)->first();
        }else {
            // $linkSettings = BiolinkSetting::where('link_id', $projectLink->id)->first();
        }

        // $linkSettings->delete();
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

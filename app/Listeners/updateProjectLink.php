<?php

namespace App\Listeners;

use App\Events\LinkSettings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ProjectLink;

class updateProjectLink
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
     * @param  \App\Events\LinkSettings  $event
     * @return void
     */
    public function handle(LinkSettings $event)
    {
        $link = $event->projectLink;

        $projectLink = ProjectLink::findOrFail($link['id']);

        $projectLink->update([
            'link_id' => $link['linkId']
        ]);
    }
}

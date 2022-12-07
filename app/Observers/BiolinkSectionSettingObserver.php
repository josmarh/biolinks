<?php

namespace App\Observers;

use App\Models\BiolinkSectionSetting;
use App\Models\BiolinkSection;

class BiolinkSectionSettingObserver
{
    /**
     * Handle the BiolinkSectionSetting "created" event.
     *
     * @param  \App\Models\BiolinkSectionSetting  $biolinkSectionSetting
     * @return void
     */
    public function created(BiolinkSectionSetting $biolinkSectionSetting)
    {
        $biolinkSectionSetting->section_position += 1;
        $biolinkSectionSetting->save();
    }

    /**
     * Handle the BiolinkSectionSetting "updated" event.
     *
     * @param  \App\Models\BiolinkSectionSetting  $biolinkSectionSetting
     * @return void
     */
    public function updated(BiolinkSectionSetting $biolinkSectionSetting)
    {
        //
    }

    /**
     * Handle the BiolinkSectionSetting "deleted" event.
     *
     * @param  \App\Models\BiolinkSectionSetting  $biolinkSectionSetting
     * @return void
     */
    public function deleting(BiolinkSectionSetting $biolinkSectionSetting)
    {
        BiolinkSection::where('section_id', $biolinkSectionSetting->id)->delete();
    }

    /**
     * Handle the BiolinkSectionSetting "deleted" event.
     *
     * @param  \App\Models\BiolinkSectionSetting  $biolinkSectionSetting
     * @return void
     */
    public function deleted(BiolinkSectionSetting $biolinkSectionSetting)
    {
        //
    }

    /**
     * Handle the BiolinkSectionSetting "restored" event.
     *
     * @param  \App\Models\BiolinkSectionSetting  $biolinkSectionSetting
     * @return void
     */
    public function restored(BiolinkSectionSetting $biolinkSectionSetting)
    {
        //
    }

    /**
     * Handle the BiolinkSectionSetting "force deleted" event.
     *
     * @param  \App\Models\BiolinkSectionSetting  $biolinkSectionSetting
     * @return void
     */
    public function forceDeleted(BiolinkSectionSetting $biolinkSectionSetting)
    {
        //
    }
}

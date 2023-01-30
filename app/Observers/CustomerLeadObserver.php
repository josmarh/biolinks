<?php

namespace App\Observers;

use App\Models\CustomerLead;
use App\Models\Subscriber;

class CustomerLeadObserver
{

    /**
     * Handle the CustomerLead "created" event.
     *
     * @param  \App\Models\CustomerLead  $customerLead
     * @return void
     */
    public function created(CustomerLead $customerLead)
    {
        // 
    }

    /**
     * Handle the CustomerLead "updated" event.
     *
     * @param  \App\Models\CustomerLead  $customerLead
     * @return void
     */
    public function updated(CustomerLead $customerLead)
    {
        $sub = Subscriber::where('email', $customerLead->email)->first();

        if($sub && !$customerLead->name) {
            $customerLead->update(['name' => $sub->name]);
        }
    }

    /**
     * Handle the CustomerLead "deleted" event.
     *
     * @param  \App\Models\CustomerLead  $customerLead
     * @return void
     */
    public function deleted(CustomerLead $customerLead)
    {
        //
    }

    /**
     * Handle the CustomerLead "restored" event.
     *
     * @param  \App\Models\CustomerLead  $customerLead
     * @return void
     */
    public function restored(CustomerLead $customerLead)
    {
        //
    }

    /**
     * Handle the CustomerLead "force deleted" event.
     *
     * @param  \App\Models\CustomerLead  $customerLead
     * @return void
     */
    public function forceDeleted(CustomerLead $customerLead)
    {
        //
    }
}

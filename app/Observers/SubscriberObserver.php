<?php

namespace App\Observers;

use App\Models\Subscriber;
use App\Models\CustomerLead;

class SubscriberObserver
{
    /**
     * Handle the Subscriber "created" event.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return void
     */
    public function created(Subscriber $subscriber)
    {
        //
    }

    /**
     * Handle the Subscriber "updated" event.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return void
     */
    public function updated(Subscriber $subscriber)
    {
        $customer = CustomerLead::where('email', $subscriber->email)->first();

        if($customer && !$customer->name && $subscriber->name) {
            $customer->update(['name' => $subscriber->name]);
        }
    }

    /**
     * Handle the Subscriber "deleted" event.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return void
     */
    public function deleted(Subscriber $subscriber)
    {
        //
    }

    /**
     * Handle the Subscriberd "restored" event.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return void
     */
    public function restored(Subscriber $subscriber)
    {
        //
    }

    /**
     * Handle the Subscriber "force deleted" event.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return void
     */
    public function forceDeleted(Subscriber $subscriber)
    {
        //
    }
}

<?php

namespace App\Listeners;

use App\Events\UserLogin;
use App\Models\LoginHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreUserLogin
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
     * @param  \App\Events\UserLogin  $event
     * @return void
     */
    public function handle(UserLogin $event)
    {
        $userDetails = $event->user;

        LoginHistory::create([
            'email' => $userDetails['email'], 
            'ip' => $userDetails['ip'], 
            'status' => $userDetails['status']
        ]);
    }
}

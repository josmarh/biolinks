<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Observers\ProjectLinkObserver;
use App\Models\ProjectLink;
use App\Observers\BiolinkSectionSettingObserver;
use App\Models\BiolinkSectionSetting;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\ProjectLinkCreated' => [
            'App\Listeners\createBiolinkSettings',
            'App\Listeners\createLinkSettings'
        ],
        'App\Events\LinkSettings' => [
            'App\Listeners\updateProjectLink',
        ],
        'App\Events\BioLinkSectionCreated' => [
            'App\Listeners\createBiolinkSection',
        ],
        'App\Events\UserLogin' => [
            'App\Listeners\StoreUserLogin',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        ProjectLink::observe(ProjectLinkObserver::class);
        BiolinkSectionSetting::observe(BiolinkSectionSettingObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}

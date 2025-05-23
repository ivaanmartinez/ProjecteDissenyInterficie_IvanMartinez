<?php

namespace App\Providers;

use App\Events\VideoCreated;
use App\Listeners\SendVideoCreatedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        VideoCreated::class => [
            SendVideoCreatedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

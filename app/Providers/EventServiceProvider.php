<?php

namespace App\Providers;

use App\Events\FollowedEvent;
use App\Events\PostHasBeenRead;
use App\Listeners\FollowedEventListener;
use App\Listeners\PostEventListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PostHasBeenRead::class => [
            PostEventListener::class
        ],
        FollowedEvent::class => [
            FollowedEventListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}

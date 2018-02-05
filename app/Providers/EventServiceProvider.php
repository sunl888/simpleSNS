<?php

/*
 * add .styleci.yml
 */

namespace App\Providers;

use App\Events\FollowedEvent;
use App\Events\CommentedEvent;
use App\Events\FeedbackedEvent;
use App\Events\PostHasBeenRead;
use App\Events\SubscribedEvent;
use App\Listeners\PostEventListener;
use App\Listeners\CommentEventListener;
use App\Listeners\FollowedEventListener;
use App\Listeners\SubscribedEventListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 文章被阅读事件
        PostHasBeenRead::class => [
            PostEventListener::class,
        ],
        // 关注事件
        FollowedEvent::class => [
            FollowedEventListener::class,
        ],
        // 订阅事件
        SubscribedEvent::class => [
            SubscribedEventListener::class,
        ],
        // 评论事件
        CommentedEvent::class => [
            CommentEventListener::class,
        ],
        // 反馈事件
        FeedbackedEvent::class => [
            FeedbackedEventListener::class,
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

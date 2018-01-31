<?php

namespace App\Listeners;

use App\Events\FollowedEvent;
use App\Notifications\FollowedNotification;
use Illuminate\Support\Facades\Notification;

class FollowedEventListener
{

    public function handle($event)
    {
        if ($event instanceof FollowedEvent) {
            // 发送通知
            Notification::send($event->user, new FollowedNotification($event->message, $event->user));
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\Followed;
use Illuminate\Support\Facades\Notification;

class FollowedEventListener
{

    public function handle($event)
    {
        if ($event instanceof Followed) {
            // 实时消息
            event(new \App\Events\PusherEvent($event->user, $event->message));
            // 发送通知
            Notification::send($event->user, new \App\Notifications\Followed($event->follow, $event->message));
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\SubscribedEvent;
use App\Notifications\SubscribedNotification;
use Illuminate\Support\Facades\Notification;

class SubscribedEventListener
{

    public function handle($event)
    {
        if ($event instanceof SubscribedEvent) {
            // 发送通知
            Notification::send($event->from, new SubscribedNotification($event->message, $event->to));
        }
    }
}

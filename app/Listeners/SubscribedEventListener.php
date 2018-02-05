<?php

/*
 * add .styleci.yml
 */

namespace App\Listeners;

use App\Events\SubscribedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SubscribedNotification;

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

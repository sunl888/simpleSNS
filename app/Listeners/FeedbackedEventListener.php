<?php

/*
 * add .styleci.yml
 */

namespace App\Listeners;

use App\Events\FeedbackedEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\FeedbackedNotification;

class FeedbackedEventListener
{
    public function handle($event)
    {
        if ($event instanceof FeedbackedEvent) {
            // 发送通知
            Notification::send($event->from, new FeedbackedNotification($event->message, $event->to));
        }
    }
}

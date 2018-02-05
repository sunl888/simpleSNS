<?php

namespace App\Listeners;

use App\Events\FeedbackedEvent;
use App\Notifications\FeedbackedNotification;
use Illuminate\Support\Facades\Notification;

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

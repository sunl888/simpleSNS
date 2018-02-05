<?php

/*
 * add .styleci.yml
 */

namespace App\Listeners;

use App\Events\CommentedEvent;
use App\Notifications\CommentNotification;
use Illuminate\Support\Facades\Notification;

class CommentEventListener
{
    public function handle($event)
    {
        if ($event instanceof CommentedEvent) {
            // 发送通知
            Notification::send($event->from, new CommentNotification($event->message, $event->to));
        }
    }
}

<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;

    public $message;
    public $to;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $message, User $to)
    {
        $this->to = $to;
        $this->message = $message;
    }

    // 发送到pusher的时候用toArray和broadcastWith()方法效果一样
    public function toArray($notifiable)
    {
        return $this->message;
    }

    public function via($notifiable)
    {
        return config('sns.notification.drivers');
    }

    public function broadcastOn()
    {
        //要发送的频道
        return ['USER_ID_' . $this->to->id];
    }

}

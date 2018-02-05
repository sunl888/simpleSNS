<?php

/*
 * add .styleci.yml
 */

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubscribedNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, User $user)
    {
        $this->user = $user;
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
        return ['USER_ID_' . $this->user->id];
    }
}

<?php

namespace App\Notifications;

use App\Models\Follow;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class Followed extends Notification
{
    use Queueable;

    protected $follow;
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Follow $follow, $message)
    {
        $this->follow = $follow;
        $this->message = $message;
    }

    public function toArray($notifiable)
    {
        return $this->message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
}

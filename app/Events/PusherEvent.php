<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PusherEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $user;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $message = [])
    {
        $this->user = $user;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        //要发送的频道
        return ['USER_ID_' . $this->user->id];
    }

    public function broadcastWith()
    {
        //发送的数据
        return $this->message;
    }
}

<?php

namespace App\Events;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Followed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $follow;
    protected $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Follow $follow, User $user)
    {
        $this->follow = $follow;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

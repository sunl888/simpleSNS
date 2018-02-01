<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CommentedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public $post;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, Post $post, User $user)
    {
        $this->comment = $comment;
        $this->post = $post;
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

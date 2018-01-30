<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class Comment extends Notification
{
    use Queueable;

    public $post;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'joke' => (new JokeResource($this->post))->resolve(),
            'user' => (new UserResource($this->user->load('avatar')))->resolve(),
        ];
    }
}

<?php

/*
 * add .styleci.yml
 */

namespace App\Events;

use App\Models\Post;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PostHasBeenRead
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;
    public $ip;

    /**
     * Create a new event instance.
     * @param Post $post
     * @param $ip
     */
    public function __construct(Post $post, $ip)
    {
        $this->post = $post;
        if ($ip == '::1') {
            $ip = '127.0.0.1';
        }
        $this->ip = $ip;
    }
}

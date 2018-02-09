<?php

/*
 * add .styleci.yml
 */

namespace App\Events;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CommentedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public $from; // 消息触发者
    public $to; // 消息接受者
    public $message; // 通知正文

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, User $from)
    {
        $this->comment = $comment;
        $this->from = $from;
        // 对文章的评论
        if ($comment->commentable_type == Post::class) {
            $post = Post::findOrFail($comment->commentable_id);
            $this->to = $post->user;
            $this->message = [
                'message' => '你的文章有了新的评论',
            ];
        }
    }
}

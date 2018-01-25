<?php

namespace App\Transformers;


use App\Models\Comment;

class CommentTransformer extends BaseTransformer
{
    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'user_id' => $comment->user_id,
            'user' =>$comment->user,
            'up_votes_count' => $comment->up_votes_count,
            'content' => $comment->content,
            'created_at' => toIso8601String($comment->created_at),
            'updated_at' => toIso8601String($comment->updated_at)
        ];
    }
}

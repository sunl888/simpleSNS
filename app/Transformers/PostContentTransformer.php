<?php

namespace App\Transformers;

use App\Models\PostContent;

class PostContentTransformer extends BaseTransformer
{
    public function transform(PostContent $postContents)
    {
        return [
            'post_id' => $postContents->post_id,
            'content' => $postContents->content,
            'created_at' => $postContents->created_at->toDateTimeString(),
            'updated_at' => $postContents->updated_at->toDateTimeString()
        ];
    }
}

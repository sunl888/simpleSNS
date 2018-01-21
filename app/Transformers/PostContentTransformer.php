<?php

namespace App\Transformers;

use App\Models\PostContent;
use League\Fractal\TransformerAbstract;

class PostContentTransformer extends TransformerAbstract
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

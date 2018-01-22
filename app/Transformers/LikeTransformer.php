<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/21
 * Time: 21:04
 */

namespace App\Transformers;


use App\Models\Like;

class LikeTransformer extends BaseTransformer
{
    public function transform(Like $like)
    {
        return [
            'id' => $like->id,
            'user' => $like->user,
            'post_id' => $like->post_id,
            'user_id' => $like->user_id,
            'created_at' => $like->created_at->toDateTimeString(),
            'updated_at' => $like->updated_at->toDateTimeString()
        ];
    }
}
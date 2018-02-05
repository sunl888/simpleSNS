<?php

/*
 * add .styleci.yml
 */

namespace App\Transformers;

use App\Models\Post;

class PostTransformer extends BaseTransformer
{
    protected $availableIncludes = ['post_content'];
    //protected $defaultIncludes = ['cover'];

    public function transform(Post $post)
    {
        return [
            'id'                => $post->id,
            'user'              => $post->user,
            'is_author'         => $post->isAuthor(), // 自己是不是作者
            //'title'             => $post->title,
            //'slug'              => $post->slug,
            'cover'             => $post->cover,
            //'excerpt'           => $post->excerpt,
            'collection'        => $post->collection,
            'status'            => $post->status,
            'views'             => $post->views,
            //'order'             => $post->order,
            'up_voters'         => $post->upVoters, // 赞
            'down_voters'       => $post->downVoters, // 踩
            'up_voters_count'   => $post->up_votes_count, // 赞
            'down_voters_count' => $post->down_votes_count, // 赞
            'published_at'      => toIso8601String($post->published_at),
            //'post_content' => $post->postContent,
            'created_at' => toIso8601String($post->created_at),
            'updated_at' => toIso8601String($post->updated_at),
        ];
    }

    public function includePostContent(Post $post)
    {
        $content = $post->postContent;
        if (null === $content) {
            return $this->null();
        } else {
            return $this->item($content, new PostContentTransformer());
        }
    }
}

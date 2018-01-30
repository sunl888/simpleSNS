<?php

namespace App\Transformers;

use App\Models\Post;

class PostTransformer extends BaseTransformer
{
    //protected $availableIncludes = ['user', 'post_content', 'cover'];
    //protected $defaultIncludes = ['cover'];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'user' => $post->user,
            'is_own' => $post->isOwn(),// 自己是不是作者
            'title' => $post->title,
            'slug' => $post->slug,
            'cover' => $post->cover,
            'excerpt' => $post->excerpt,
            'collection' => $post->collection,
            'status' => $post->status,
            'views' => $post->views,
            'order' => $post->order,
            'up_voters' => $post->upVoters,// 赞
            'down_voters' => $post->downVoters,// 踩
            'up_voters_count' => $post->up_votes_count,// 赞
            'down_voters_count' => $post->down_votes_count,// 赞
            'published_at' => $post->published_at,
            'post_content' => $post->postContent,
            'created_at' => $post->created_at->toDateTimeString(),
            'updated_at' => $post->updated_at->toDateTimeString()
        ];
    }

    /*public function includeCover(Post $post)
    {
        if (!$post->cover) {
            return $this->null();
        }
        return $this->item($post->cover()->first(), new ImageTransformer());
    }

    public function includeUser(Post $post)
    {
        $user = $post->user;
        if (is_null($user)) {
            return $this->null();
        } else {
            return $this->item($user, new UserTransformer());
        }
    }

    public function includePostContent(Post $post)
    {
        $content = $post->postContent;
        if (is_null($content)) {
            return $this->null();
        } else {
            return $this->item($content, new PostContentTransformer());
        }
    }*/

}

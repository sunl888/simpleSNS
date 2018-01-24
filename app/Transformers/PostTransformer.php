<?php

namespace App\Transformers;

use App\Models\Post;

class PostTransformer extends BaseTransformer
{
    protected $availableIncludes = ['user', 'post_content', 'category', 'tags', 'likes'];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'user_id' => $post->user_id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'cover' => image_url($post->cover),
            'category_id' => $post->category_id,
            'status' => $post->status,
            'views' => $post->views,
            'likes' => $post->likes,
            'order' => $post->order,
            'published_at' => $post->published_at,
            'created_at' => $post->created_at->toDateTimeString(),
            'updated_at' => $post->updated_at->toDateTimeString()
        ];
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
    }

    public function includeCategory(Post $post)
    {
        $category = $post->category;
        if (is_null($category)) {
            return $this->null();
        }
        return $this->item($category, new CategoryTransformer());
    }

    public function includeTags(Post $post)
    {
        $tags = $post->tags;
        if (is_null($tags)) {
            return $this->null();
        }
        return $this->collection($tags, new TagTransformer());
    }

    public function includeLikes(Post $post)
    {
        $likes = $post->likes()->get();
        if (is_null($likes)) {
            return $this->null();
        }
        return $this->collection($likes, new LikeTransformer());
    }
}

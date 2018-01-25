<?php

namespace App\Transformers;

use App\Models\Post;

class PostTransformer extends BaseTransformer
{
    protected $availableIncludes = ['user', 'post_content', 'category', 'tags', 'cover'];
    protected $defaultIncludes = ['cover'];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'user_id' => $post->user_id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'category_id' => $post->category_id,
            'status' => $post->status,
            'views' => $post->views,
            'order' => $post->order,
            'up_voters' => $post->upVoters,// 赞
            'down_voters' => $post->downVoters,// 踩
            'published_at' => $post->published_at,
            'created_at' => $post->created_at->toDateTimeString(),
            'updated_at' => $post->updated_at->toDateTimeString()
        ];
    }

    public function includeCover(Post $post)
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

    /*public function includeVoters(Post $post)
    {
        $votes = $post->voters();
        if (is_null($votes)) {
            return $this->null();
        }dd($votes->get());
        return $this->collection($votes, new VoteTransformer());
    }*/
}

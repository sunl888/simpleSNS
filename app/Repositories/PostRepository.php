<?php

namespace App\Repositories;

use App\Models\Post;
use App\Services\PostService;
use Auth;
use Carbon\Carbon;

class PostRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    public function preCreate(array &$data)
    {
        $this->filterData($data);

        $postService = app(PostService::class);
        if (!isset($data['published_at'])) {
            $data['published_at'] = Carbon::now();
        }
        if (!isset($data['status']))
            $data['status'] = Post::STATUS_DRAFT;

        if (!isset($data['excerpt']))
            $data['excerpt'] = $postService->makeExcerpt($data['content']);

        $data['user_id'] = Auth::id();
        $data['slug'] = $this->model->generateSlug($data['title']);
        return $data;
    }

    public function filterData(array &$data)
    {
        if (isset($data['title']))
            $data['title'] = e($data['title']);
        if (isset($data['excerpt']))
            $data['excerpt'] = e($data['excerpt']);
        if (isset($data['content']))
            $data['content'] = clean($data['content']);
        if (isset($data['published_at']))
            $data['published_at'] = Carbon::createFromTimestamp(strtotime($data['published_at']));

        return $data;
    }

    public function created(&$data, $post)
    {
        $this->updateOrCreatePostContent($post, $data);
        $this->addTags($post, $data);
    }

    /**
     * 更新或创建文章正文
     * @param Post $post
     * @param $content
     */
    private function updateOrCreatePostContent(Post $post, &$data)
    {
        if (isset($data['content'])) {
            $post->postContent()->updateOrCreate(
                [], [
                    'content' => $data['content']
                ]
            );
        }
    }

    /**
     * 添加标签
     * @param Post $post
     * @param $data
     */
    private function addTags(Post $post, &$data)
    {
        if (isset($data['tag_ids'])) {
            $post->tags()->attach($data['tag_ids']);
        }
    }

    public function preUpdate(array &$data, $post)
    {
        $data = $this->filterData($data);

        if (isset($data['title']) && $post->title != $data['title']) {
            $data['slug'] = $this->model->generateSlug($data['title']);
        }
        if (!isset($data['excerpt']) && isset($data['content'])) {
            $data['excerpt'] = app(PostService::class)->makeExcerpt($data['content']);
        }
        return $data;
    }

    public function updated(&$data, $post)
    {
        $this->updateOrCreatePostContent($post, $data);
        $this->syncTags($post, $data);
    }

    /**
     * 同步标签
     * @param Post $post
     * @param $data
     */
    private function syncTags(Post $post, &$data)
    {
        if (isset($data['tag_ids'])) {
            $post->tags()->sync($data['tag_ids']);
        }
    }

    public function addLikes(Post $post)
    {
        $post->addLikes();
        $attributes = ['user_id' => Auth::id(), 'post_id' => $post->id];
        $post->likes()->where($attributes)->firstOrCreate($attributes);
    }

    public function subLike(Post $post)
    {
        $post->subLikes();
        $attributes = ['user_id' => Auth::id(), 'post_id' => $post->id];
        $post->likes()->where($attributes)->delete();
    }
}

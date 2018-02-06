<?php

/*
 * add .styleci.yml
 */

namespace App\Repositories;

use Auth;
use Carbon\Carbon;
use App\Models\Post;
use App\Services\PostService;

class PostRepository extends BaseRepository
{
    /**
     * Specify Model class name.
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
        if (! isset($data['published_at'])) {
            $data['published_at'] = Carbon::now();
        }
        if (! isset($data['status'])) {
            $data['status'] = Post::STATUS_DRAFT;
        }

        /*if (! isset($data['excerpt'])) {
            $data['excerpt'] = $postService->makeExcerpt($data['content']);
        }*/

        $data['user_id'] = Auth::id();
        //$data['slug'] = $this->model->generateSlug($data['title']);
        $data['up_votes_count'] = 0;
        $data['comment_count'] = 0;

        return $data;
    }

    public function filterData(array &$data)
    {
        /*if (isset($data['title'])) {
            $data['title'] = e($data['title']);
        }
        if (isset($data['excerpt'])) {
            $data['excerpt'] = e($data['excerpt']);
        }*/
        if (isset($data['content'])) {
            $data['content'] = clean($data['content']);
        }
        if (isset($data['published_at'])) {
            $data['published_at'] = Carbon::createFromTimestamp(strtotime($data['published_at']));
        }

        return $data;
    }

    public function created(&$data, $post)
    {
        $this->updateOrCreatePostContent($post, $data);
    }

    /**
     * 更新或创建文章正文.
     * @param Post $post
     * @param $content
     */
    private function updateOrCreatePostContent(Post $post, &$data)
    {
        if (isset($data['content'])) {
            $post->postContent()->updateOrCreate(
                [], [
                    'content' => $data['content'],
                ]
            );
        }
    }

    public function preUpdate(array &$data, $post)
    {
        $data = $this->filterData($data);

        /*if (isset($data['title']) && $post->title != $data['title']) {
            $data['slug'] = $this->model->generateSlug($data['title']);
        }
        if (! isset($data['excerpt']) && isset($data['content'])) {
            $data['excerpt'] = app(PostService::class)->makeExcerpt($data['content']);
        }*/

        return $data;
    }

    public function updated(&$data, $post)
    {
        $this->updateOrCreatePostContent($post, $data);
    }
}

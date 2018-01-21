<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Post;
use App\Services\PostService;
use Auth;
use Carbon\Carbon;
use Naux\AutoCorrect;

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
        // 创建文章时 如果没有传入 published_at 字段，将 published_at 设置为 Carbon::now()
        if (!isset($data['published_at'])) {
            $data['published_at'] = Carbon::now();
        }
        // 创建文章时 如果没有传入 type 字段，type 默认设置为 Category::TYPE_POST
        if (!isset($data['type']))
            $data['type'] = Category::TYPE_POST;
        // 创建文章时 如果没有传入 status 字段，status 默认设置为 Post::STATUS_DRAFT
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
            $data['title'] = e((new AutoCorrect())->convert($data['title']));
        if (isset($data['excerpt']))
            $data['excerpt'] = e($data['excerpt']);
        if (isset($data['content']))
            $data['content'] = clean($data['content']);
        // 处理置顶
        if (isset($data['top'])) {
            if ($data['top']) {
                $data['top'] = Carbon::now();
            } else {
                $data['top'] = null;
            }
        }
        if (isset($data['published_at']))
            $data['published_at'] = Carbon::createFromTimestamp(strtotime($data['published_at']));
        if (isset($data['top_expired_at']))
            $data['top_expired_at'] = Carbon::createFromTimestamp(strtotime($data['top_expired_at']));
        if (isset($data['fields']))
            $data['fields'] = json_encode($data['fields']);

        return $data;
    }

    public function created(&$data, $post)
    {
        $this->updateOrCreatePostContent($post, $data);
        $this->addAttachments($post, $data);
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
     * 添加附件
     * @param Post $post
     * @param $data
     */
    private function addAttachments(Post $post, &$data)
    {
        if (isset($data['attachment_ids'])) {
            $post->attachments()->attach($data['attachment_ids']);
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
        $this->syncAttachments($post, $data);
        $this->syncTags($post, $data);
    }

    /**
     * 同步附件
     * @param Post $post
     * @param $data
     */
    private function syncAttachments(Post $post, &$data)
    {
        if (isset($data['attachment_ids'])) {
            $post->attachments()->sync($data['attachment_ids']);
        }
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
}

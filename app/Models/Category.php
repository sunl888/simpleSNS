<?php

namespace App\Models;

use App\Models\Traits\HasSlug;

class Category extends BaseModel
{
    use HasSlug;

    protected $fillable = ['image', 'cate_name', 'order', 'description', 'cate_slug', 'creator_id'];

    /**
     * 文章列表
     * @param  $query
     * @return mixed
     */
    public function postListWithOrder($order = null)
    {
        $query = $this->posts()->byStatus(Post::STATUS_PUBLISH);
        switch ($order) {
            case 'default':
                $query->ordered()->recent();
                break;
            case 'recent':
                $query->recent()->ordered();
                break;
            case 'popular':
                $query->orderBy('viewss', 'desc')->recent();
                break;
            default:
                $query->ordered()->recent();
                break;
        }
        return $query;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 获取当前分类下的热门文章
     *
     * @param  $limit
     * @param  null $exceptPost
     * @return mixed
     */
    public function getHotPosts($limit, $exceptPost = null)
    {
        $query = $this->posts()->publishPost();
        if ($exceptPost != null) {
            if (is_numeric($exceptPost)) {
                $query->where('id', '!=', $exceptPost);
            } elseif ($exceptPost instanceof Post) {
                $query->where('id', '!=', $exceptPost->id);
            }
        }
        return $query->orderBy('views', 'desc')->recent()->limit($limit)->get();
    }

    public function slugKey(): string
    {
        return 'cate_slug';
    }

    public function slugMode()
    {
        return config('sns.default_slug_mode');
    }

}

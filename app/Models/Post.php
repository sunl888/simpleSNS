<?php

namespace App\Models;

use App\Models\Traits\HasSlug;
use App\Models\Traits\Listable;
use App\Models\Traits\Sortable;


class Post extends BaseModel
{
    use Listable, Sortable, HasSlug;

    const STATUS_PUBLISH = 'publish', STATUS_DRAFT = 'draft';
    protected $fillable = ['title', 'user_id', 'slug', 'excerpt', 'views', 'cover', 'likes', 'status', 'published_at', 'category_id', 'order'];
    protected $dates = ['published_at', 'created_at', 'updated_at'];

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc')->orderBy('created_at', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeApplyFilter($query, $data)
    {
        $data = $data->only('status', 'category_id','hot','');

        $query->byCategory($data['category_id'] ?? null)
            ->byStatus($data['status'] ?? null);

        return $query->ordered()->recent();
    }

    public function scopeByCategory($query, $category)
    {
        if ($category instanceof Category) {
            $category = $category->id;
        } else {
            $category = intval($category);
        }
        if ($category)
            $query->where('category_id', $category);
    }

    public function scopeByStatus($query, $status)
    {
        if (in_array($status, [static::STATUS_PUBLISH, static::STATUS_DRAFT]))
            return $query->where('status', $status);
        else
            return $query->publishOrDraft();
    }

    public function scopePublishOrDraft($query)
    {
        return $query->where('status', static::STATUS_PUBLISH)->orWhere('status', static::STATUS_DRAFT);
    }

    public function scopePublishPost($query)
    {
        return $query->byStatus(static::STATUS_PUBLISH);
    }

    public function scopeDraftPost($query)
    {
        return $query->byStatus(static::STATUS_DRAFT);
    }

    /**
     * 文章浏览量增加
     * @return int
     */
    public function addViews()
    {
        return $this->increment('views');
    }

    /**
     * 文章点赞数量加 1
     * @return int
     */
    public function addLikes()
    {
        return $this->increment('likes');
    }

    /**
     * 文章点赞数量减 1
     * @return int
     */
    public function subLikes()
    {
        return $this->decrement('likes');
    }

    public function postContent()
    {
        return $this->hasOne(PostContent::class);
    }

    public function isPublish()
    {
        return $this->status == static::STATUS_PUBLISH;
    }

    public function isDraft()
    {
        return $this->status == static::STATUS_DRAFT;
    }

    /**
     * 标签
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // todo 这里好像有问题
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function slugMode()
    {
        return config('sns.default_slug_mode');
    }

}

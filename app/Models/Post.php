<?php

namespace App\Models;

use App\Models\Presenter\PostPresenter;
use App\Models\Traits\Listable;
use App\Models\Traits\Sortable;
use App\Support\Presenter\PresentableInterface;


class Post extends BaseModel
{
    use Listable, Sortable;

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
        /*$data = $data->only('status', 'only_trashed', 'category_id');
        $query->orderByTop()
            ->byCategory(isset($data['category_id']) ? $data['category_id'] : null)
            ->byType(Category::TYPE_POST)
            ->byStatus(isset($data['status']) ? $data['status'] : null);

        if (isset($data['only_trashed']) && $data['only_trashed']) {
            $query->onlyTrashed();
        }*/
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
        return $query->where(function ($query) {
            $query->byType(Category::TYPE_POST)->byStatus(static::STATUS_PUBLISH);
        });
    }

    public function addViewCount()
    {
        return $this->increment('views_count');
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

    public function slugMode()
    {
        return setting('post_slug_mode');
    }

}

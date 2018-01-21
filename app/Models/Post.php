<?php

namespace App\Models;

use App\Models\Presenter\PostPresenter;
use App\Models\Traits\HasSlug;
use App\Models\Traits\Listable;
use App\Support\Presenter\PresentableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends BaseModel implements PresentableInterface
{
    use SoftDeletes, Listable, HasSlug;

    protected $fillable = ['title', 'user_id', 'slug', 'excerpt', 'type', 'views_count', 'cover', 'status', 'template', 'top', 'top_expired_at', 'published_at', 'category_id', 'order', 'fields'];
    protected $dates = ['deleted_at', 'top', 'top_expired_at', 'published_at', 'created_at', 'updated_at'];
    protected static $allowSearchFields = ['title', 'excerpt'];
    protected static $allowSortFields = ['title', 'status', 'views_count', 'top', 'order', 'published_at', 'category_id'];

    const STATUS_PUBLISH = 'publish', STATUS_DRAFT = 'draft';

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
        $data = $data->only('status', 'only_trashed', 'category_id');
        $query->orderByTop()
            ->byCategory(isset($data['category_id']) ? $data['category_id'] : null)
            ->byType(Category::TYPE_POST)
            ->byStatus(isset($data['status']) ? $data['status'] : null);

        if (isset($data['only_trashed']) && $data['only_trashed']) {
            $query->onlyTrashed();
        }
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


    public function scopeByType($query, $type)
    {
        if (in_array($type, [Category::TYPE_POST, Category::TYPE_PAGE]))
            return $query->where('type', $type);
        return $query;
    }

    public function scopeByStatus($query, $status)
    {
        if (in_array($status, [static::STATUS_PUBLISH, static::STATUS_DRAFT]))
            return $query->where('status', $status);
        else
            return $query->publishOrDraft();
    }

    /**
     * 获取已发布或草稿的文章的查询作用域
     * @param $query
     * @return mixed
     */
    public function scopePublishOrDraft($query)
    {
        return $query->where('status', static::STATUS_PUBLISH)->orWhere('status', static::STATUS_DRAFT);
    }

    /**
     * 已发布文章的查询作用域
     * @param $query
     * @return mixed
     */
    public function scopePublishPost($query)
    {
        return $query->where(function ($query) {
            $query->byType(Category::TYPE_POST)->byStatus(static::STATUS_PUBLISH);
        });
    }

    public function scopeOrderByTop($query)
    {
        return $query->orderBy('top', 'DESC');
    }

    public function addViewCount()
    {
        return $this->increment('views_count');
    }

    /**
     * 一对一关联 post_content 表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function postContent()
    {
        return $this->hasOne(PostContent::class);
    }


    /**
     * 文章是否置顶
     */
    public function isTop()
    {
        return !is_null($this->top);
    }

    /**
     * 获取下一篇文章
     * @return mixed
     */
    public function getNextPost()
    {
        return $this->category->posts()->publishPost()->where('id', '>', $this->id)->first();
    }

    public function isPublish()
    {
        return $this->status == static::STATUS_PUBLISH;
    }

    public function isDraft()
    {
        return $this->status == static::STATUS_DRAFT;
    }


    public function getPresenter()
    {
        return new PostPresenter($this);
    }

    /**
     * 附件
     */
    public function attachments()
    {
        return $this->belongsToMany(Attachment::class);
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

    private $fieldsCache = null;

    public function getFieldsAttribute($fields)
    {
        if (is_null($this->fieldsCache)) {
            $this->fieldsCache = json_decode($fields, true);
        }
        return $this->fieldsCache;
    }

    public function getFieldByKey($key)
    {
        return $this->fields[$key];
    }

    /**
     * meta keywords
     * @return string
     */
    public function getKeywords()
    {
        $tagStr = $this->tags->implode('name', ',');
        return $this->category->cate_name . ',' . $tagStr . setting('default_keywords');

    }

    /**
     * meta description
     */
    public function getDescription()
    {
        return $this->excerpt ?: setting('default_description');
    }

}

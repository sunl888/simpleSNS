<?php

namespace App\Models;

use App\Models\Traits\HasSlug;
use App\Models\Traits\Listable;
use App\Models\Traits\Sortable;
use Ty666\LaravelVote\Contracts\CanCountUpVotesModel;
use Ty666\LaravelVote\Traits\CanBeVoted;
use Ty666\LaravelVote\Traits\CanCountUpVotes;


class Post extends BaseModel implements CanCountUpVotesModel
{
    use Listable, Sortable, HasSlug;
    use CanBeVoted, CanCountUpVotes;

    const STATUS_PUBLISH = 'publish', STATUS_DRAFT = 'draft';
    protected $fillable = ['title', 'user_id', 'slug', 'excerpt', 'views', 'cover', 'up_votes_count', 'comment_count','status', 'published_at', 'category_id', 'order'];
    protected $dates = ['published_at', 'created_at', 'updated_at'];

    protected $upVotesCountField = 'up_votes_count';

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc')->orderBy('created_at', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cover()
    {
        return $this->hasOne(Image::class, 'hash', 'cover');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeApplyFilter($query, $data)
    {
        $data = $data->only('status', 'category_id', 'hot', '');

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
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

    public function scopeByUser($query, $user)
    {
        if ($user instanceof User)
            $user = $user->id;
        $query->where('user_id', $user);
    }

    /**
     * 标签
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}

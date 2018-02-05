<?php

namespace App\Models;

use App\Models\Traits\HasSlug;
use App\Models\Traits\Sortable;
use App\Transformers\ImageTransformer;
use Ty666\LaravelVote\Contracts\CanCountUpVotesModel;
use Ty666\LaravelVote\Traits\CanBeVoted;
use Ty666\LaravelVote\Traits\CanCountDownVotes;
use Ty666\LaravelVote\Traits\CanCountUpVotes;


class Post extends BaseModel implements CanCountUpVotesModel
{
    use  Sortable, HasSlug;
    use CanBeVoted, CanCountUpVotes, CanCountDownVotes;

    const STATUS_PUBLISH = 'publish', STATUS_DRAFT = 'draft';
    protected $fillable = [
        'title', 'user_id', 'slug', 'excerpt', 'views', 'cover', 'up_votes_count', 'comment_count',
        'status', 'published_at', 'collection_id', 'order'
    ];
    protected $dates = ['published_at', 'created_at', 'updated_at'];

    protected $upVotesCountField = 'up_votes_count';
    protected $downVotesCountField = 'down_votes_count';

    public function scopeApplyFilter($query, $data)
    {
        $data = $data->only('user_id', 'collection_id');
        // todo 这里过滤
        if (isset($data['user_id']))
            $query->where('user_id', $data['user_id']);
        if (isset($data['collection_id']))
            $query->where('collection_id', $data['collection_id']);

        return $query->ordered()->recent();
    }

    // 封面信息
    public function getCoverAttribute($value)
    {
        return app(ImageTransformer::class)->transform(Image::find($value));
    }

    // 文章所属收藏集
    public function collection()
    {
        return $this->hasOne(Collection::class, 'id', 'collection_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cover()
    {
        return $this->hasOne(Image::class, 'hash', 'cover');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function postContent()
    {
        return $this->hasOne(PostContent::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopeByCollection($query, $collection)
    {
        if ($collection instanceof Collection) {
            $collection = $collection->id;
        } else {
            $collection = intval($collection);
        }
        if ($collection)
            $query->where('collection_id', $collection);
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

    public function scopeByUser($query, $user)
    {
        if ($user instanceof User)
            $user = $user->id;
        $query->where('user_id', $user);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc')->orderBy('created_at', 'desc');
    }

    /**
     * 文章浏览量增加
     * @return int
     */
    public function addViews()
    {
        return $this->increment('views');
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
     * @return bool
     */
    public function isAuthor(): bool
    {
        return $this->user_id === auth()->id();
    }
}

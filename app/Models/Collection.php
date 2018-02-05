<?php

/*
 * add .styleci.yml
 */

namespace App\Models;

use App\Models\Traits\HasSlug;
use App\Transformers\ImageTransformer;
use Overtrue\LaravelFollow\Traits\CanBeSubscribed;

class Collection extends BaseModel
{
    // slug 排序 被订阅
    use HasSlug, CanBeSubscribed;

    protected $fillable = ['title', 'collect_slug', 'introduction', 'color', 'cover', 'user_id'];

    public function scopeApplyFilter($query, $data)
    {
        $data = $data->only('slug', 'user_id');

        if (isset($data['slug'])) {
            $query->bySlug($data['slug']);
        }
        if (isset($data['user_id'])) {
            $query->where('user_id', $data['user_id']);
        }

        return $query->latest();
    }

    // 封面信息
    public function getCoverAttribute($value)
    {
        return app(ImageTransformer::class)->transform(Image::find($value));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function slugKey(): string
    {
        return 'collect_slug';
    }

    /**
     * @return bool
     */
    public function isAuthor(): bool
    {
        return $this->user_id === auth()->id();
    }
}

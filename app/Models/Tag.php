<?php

namespace App\Models;

use App\Models\Traits\HasSlug;
use App\Models\Traits\Listable;

class Tag extends BaseModel
{
    use HasSlug, Listable;

    public static $allowSearchFields = ['name', 'slug'];
    protected $fillable = ['name', 'slug','image', 'creator_id'];

    /**
     * 获得此标签下所有的文章。
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function slugMode()
    {
        return config('sns.default_slug_mode');
    }
}

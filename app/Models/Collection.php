<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/21
 * Time: 20:00
 */

namespace App\Models;


use App\Models\Traits\HasSlug;
use App\Models\Traits\Sortable;

class Collection extends BaseModel
{
    use HasSlug, Sortable;

    protected $fillable = ['title', 'collect_slug', 'introduction', 'color', 'cover', 'user_id'];

    public function scopeApplyFilter($query, $data)
    {
        $data = $data->only('slug', 'user_id', 'hot', '');

        if (isset($data['slug']))
            $query->where('collect_slug', $data['slug']);
        if (isset($data['user_id']))
            $query->where('user_id', $data['user_id']);

        return $query->ordered()->recent();
    }

    /**
     * 获得此收藏集的所有关注者。
     */
    public function follows()
    {
        return $this->hasMany(Follow::class, 'follow_id')->byType(get_class($this));
    }

    public function slugKey(): string
    {
        return 'collect_slug';
    }

    public function slugMode()
    {
        return config('sns.default_slug_mode');
    }
}
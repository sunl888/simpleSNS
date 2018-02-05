<?php

/*
 * add .styleci.yml
 */

namespace App\Transformers;

use App\Models\Collection;

class CollectionTransformer extends BaseTransformer
{
    public function transform(Collection $collection)
    {
        return [
            'id'           => $collection->id,
            'title'        => $collection->title,
            'collect_slug' => $collection->collect_slug,
            'introduction' => $collection->introduction,
            'color'        => $collection->color,
            'cover'        => $collection->cover,
            // 收藏集创建者
            'user' => $collection->user,
            // 收藏集订阅者s
            'subscriptions' => $collection->subscribers,
            'created_at'    => toIso8601String($collection->created_at),
            'updated_at'    => toIso8601String($collection->updated_at),
        ];
    }
}

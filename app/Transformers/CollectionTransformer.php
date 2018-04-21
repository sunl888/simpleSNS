<?php

/*
 * add .styleci.yml
 */

namespace App\Transformers;

use App\Models\Collection;

class CollectionTransformer extends BaseTransformer
{
    protected $availableIncludes = ['subscribers'];

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
            // 我是否订阅了这个收藏集
            //TODO  这里必须要用户登陆才行
            'isSubscribedByMe' => auth()->check() ? $collection->isSubscribedBy(me()) : false,
            // 收藏集订阅者s
            //'subscriptions' => $collection->subscribers,
            'created_at' => toIso8601String($collection->created_at),
            'updated_at' => toIso8601String($collection->updated_at),
        ];
    }

    // 收藏集的订阅者s
    public function includeSubscribers(Collection $collection)
    {
        $subscribers = $collection->subscribers;
        if ($subscribers->isEmpty()) {
            return $this->null();
        }

        return $this->collection($subscribers, new UserTransformer());
    }
}

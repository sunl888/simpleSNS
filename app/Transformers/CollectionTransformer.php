<?php

namespace App\Transformers;


use App\Models\Collection;

class CollectionTransformer extends BaseTransformer
{
    public function transform(Collection $collection)
    {
        return [
            'id' => $collection->id,
            'user_id' => $collection->user_id,
            'title' => $collection->title,
            'collect_slug' => $collection->collect_slug,
            'introduction' => $collection->introduction,
            'color' => $collection->color,
            'cover' => $collection->cover,
            'created_at' => toIso8601String($collection->created_at),
            'updated_at' => toIso8601String($collection->updated_at)
        ];
    }
}

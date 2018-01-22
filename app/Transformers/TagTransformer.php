<?php

namespace App\Transformers;

use App\Models\Tag;

class TagTransformer extends BaseTransformer
{

    public function transform(Tag $tag)
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug,
            'created_at' => $tag->created_at->toDateTimeString(),
            'updated_at' => $tag->updated_at->toDateTimeString()
        ];
    }
}

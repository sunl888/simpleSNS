<?php

namespace App\Transformers;

use App\Models\Category;

class CategoryTransformer extends BaseTransformer
{
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'image' => $category->image,
            'image_url' => image_url($category->image),
            'cate_name' => $category->cate_name,
            'description' => $category->description,
            'cate_slug' => $category->cate_slug,
            'order' => $category->order,
            'created_at' => $category->created_at->toDateTimeString(),
            'updated_at' => $category->updated_at->toDateTimeString()
        ];
    }
}

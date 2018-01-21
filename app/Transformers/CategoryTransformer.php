<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    // todo 此处注释是否有问题
    // protected $defaultIncludes = ['children'];
    protected $availableIncludes = ['children'];

    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'type' => $category->type,
            'image' => $category->image,
            'image_url' => image_url($category->image),
            'parent_id' => $category->parent_id,
            'cate_name' => $category->cate_name,
            'description' => $category->description,
            'url' => $category->url,
            'slug' => $category->cate_slug,
            'is_nav' => $category->is_nav,
            'order' => $category->order,
            'page_template' => $category->page_template,
            'list_template' => $category->list_template,
            'content_template' => $category->content_template,
            // 'setting' => $category->setting,
            'is_target_blank' => $category->is_target_blank,
            'created_at' => $category->created_at->toDateTimeString(),
            'updated_at' => $category->updated_at->toDateTimeString()
        ];
    }

    public function includeChildren(Category $category)
    {
        $transformer = new static;
        $transformer->setAvailableIncludes([]);
        $transformer->setDefaultIncludes([]);
        return $this->collection($category->children, $transformer);
    }
}

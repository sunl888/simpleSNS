<?php

namespace App\Repositories;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Support\Arr;

class CategoryRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    public function filterData(array &$data, $category = null)
    {
        $filterValues = [
            Category::TYPE_LINK => ['page_template', 'list_template', 'content_template'],
            Category::TYPE_PAGE => ['url', 'is_target_blank', 'list_template', 'content_template'],
            Category::TYPE_POST => ['url', 'is_target_blank', 'page_template'],
        ];

        foreach ($filterValues as $type => $filterValue) {
            $cateType = isset($data['type']) ? $data['type'] : $category->type;
            if ($cateType == $type) {
                $data = Arr::except($data, $filterValue);
                break;
            }
        }
        if (isset($data['cate_name']))
            $data['cate_name'] = e($data['cate_name']);
        if (isset($data['description']))
            $data['description'] = e($data['description']);
        return $data;
    }

    public function preCreate(array &$data)
    {
        $data = $this->filterData($data);
        // CategoryModel
        $data['cate_slug'] = $this->model->generateSlug($data['cate_name']);
        $data['creator_id'] = auth()->id();
        return $data;
    }


    public function preUpdate(array &$data, $category)
    {
        $data = $this->filterData($data, $category);
        if (isset($data['cate_name']) && $category->title != $data['cate_name']) {
            $data['cate_slug'] = $this->model->generateSlug($data['cate_name']);
        }
        return $data;
    }

    public function findByCateName($cateName)
    {
        return $this->model->where('cate_name', $cateName)->firstOrFail();
    }
}

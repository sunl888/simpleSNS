<?php

namespace App\Repositories;

use App\Models\Category;

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

    public function preCreate(array &$data)
    {
        $data = $this->filterData($data);
        $data['cate_slug'] = $this->model->generateSlug($data['cate_name']);
        $data['creator_id'] = auth()->id();
        return $data;
    }

    public function filterData(array &$data, $category = null)
    {
        if (isset($data['cate_name']))
            $data['cate_name'] = e($data['cate_name']);
        if (isset($data['description']))
            $data['description'] = e($data['description']);
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

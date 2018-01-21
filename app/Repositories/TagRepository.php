<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tag::class;
    }

    public function preCreate(array &$data)
    {
        $data = $this->filterData($data);
        $data['slug'] = $this->model->generateSlug($data['name']);
        $data['creator_id'] = auth()->id();
        return $data;
    }

    public function filterData(array &$data)
    {
        if (isset($data['name']))
            $data['name'] = e($data['name']);
        return $data;
    }

    public function preUpdate(array &$data, $tag)
    {
        $data = $this->filterData($data);
        if (isset($data['name']) && $tag->name != $data['name']) {
            $data['slug'] = $this->model->generateSlug($data['name']);
        }
        return $data;
    }

}

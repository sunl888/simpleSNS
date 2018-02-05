<?php

/*
 * add .styleci.yml
 */

namespace App\Repositories;

use App\Models\Collection;

class CollectionRepository extends BaseRepository
{
    public function model()
    {
        return Collection::class;
    }

    public function preCreate(array &$data)
    {
        $this->filterData($data);
        $data['collect_slug'] = $this->model->generateSlug($data['title']);
        $data['user_id'] = auth()->id();

        return $data;
    }

    public function preUpdate(array &$data, $collection)
    {
        $data = $this->filterData($data);
        if (isset($data['title']) && $collection->title != $data['title']) {
            $data['collect_slug'] = $this->model->generateSlug($data['title']);
        }

        return $data;
    }

    public function filterData(array &$data)
    {
        if (isset($data['title'])) {
            $data['title'] = e($data['title']);
        }
        if (isset($data['introduction'])) {
            $data['introduction'] = e($data['introduction']);
        }

        return $data;
    }
}

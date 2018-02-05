<?php

namespace App\Repositories;

use App\Events\FollowedEvent;
use App\Models\Follow;

class FollowRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Follow::class;
    }

    public function createFollow($data)
    {
        $data['user_id'] = auth()->id();
        if ($this->model->where($data)->first()) {
            return true;
        }
        return $this->create($data);
    }

    public function cancelFollow($data)
    {
        $data['user_id'] = auth()->id();
        $this->model->where($data)->delete();
        return true;
    }

    public function preCreate(array &$data)
    {
        $this->filterData($data);
        return $data;
    }

    public function created($data, $model)
    {
        // 通知
        event(new FollowedEvent($model, auth()->user()));
    }

    public function filterData(array &$data)
    {
        return $data;
    }

}

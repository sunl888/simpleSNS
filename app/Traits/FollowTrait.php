<?php

namespace App\Traits;


use App\Repositories\FollowRepository;

trait FollowTrait
{
    public function storeFollow($id, $type = 'create', FollowRepository $followRepository)
    {
        $data['follow_type'] = static::$model;
        $data['follow_id'] = $id;
        if ($type == 'create')
            $followRepository->createFollow($data);
        else
            $followRepository->cancelFollow($data);

        return $this->response()->noContent();
    }

    public function cancelFollow($id, FollowRepository $followRepository)
    {
        return $this->storeFollow($id, 'cancel', $followRepository);
    }
}

<?php

/*
 * add .styleci.yml
 */

namespace App\Transformers;

use App\Models\Collection;
use App\Models\User;

class UserTransformer extends BaseTransformer
{
    protected $availableIncludes = ['collections','subscribe_collections'];

    /*protected $defaultIncludes = ['avatar'];*/

    public function transform(User $user)
    {
        return [
            'id'           => $user->id,
            'nickname'     => $user->nickname,
            'email'        => $user->email,
            'tel_num'      => $user->tel_num,
            'avatar_hash'  => $user->avatar_hash,
            'introduction' => $user->introduction,
            'city'         => $user->city,
            'location'     => $user->location,
            'company'      => $user->company,
            'username'     => $user->username,
            'name'         => $user->name,
            'created_at'   => toIso8601String($user->created_at),
            'updated_at'   => toIso8601String($user->updated_at),
        ];
    }

    // 创建的收藏集
    public function includeCollections(User $user)
    {
        if ($user->collections->isEmpty()) {
            return $this->null();
        }
        return $this->collection($user->collections, new CollectionTransformer());
    }

    // 订阅的收藏集
    public function includeSubscribeCollections(User $user)
    {
        $subscriptions = $user->subscriptions(Collection::class)->get();
        if ($subscriptions->isEmpty()) {
            return $this->null();
        }
        return $this->collection($subscriptions, new CollectionTransformer());
    }
}

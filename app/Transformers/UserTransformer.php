<?php

namespace App\Transformers;

use App\Models\User;

class UserTransformer extends BaseTransformer
{
    /*protected $availableIncludes = ['avatar'];
    protected $defaultIncludes = ['avatar'];*/

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'nickname' => $user->nickname,
            'email' => $user->email,
            'tel_num' => $user->tel_num,
            'avatar_hash' => $user->avatar_hash,
            'introduction' => $user->introduction,
            'city' => $user->city,
            'location' => $user->location,
            'company' => $user->company,
            'username' => $user->username,
            'name' => $user->name,
            'created_at' => toIso8601String($user->created_at),
            'updated_at' => toIso8601String($user->updated_at)
        ];
    }

    /*public function includeAvatar(User $user)
    {
        if (!$user->avatar) {
            return $this->null();
        }
        return $this->item($user->avatar, new ImageTransformer());
    }*/

}

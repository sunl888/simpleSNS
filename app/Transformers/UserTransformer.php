<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\ParamBag;

class UserTransformer extends BaseTransformer
{
    protected $availableIncludes = ['posts', 'follows', 'likes'];

    private $validParams = ['limit', 'order'];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'nickname' => $user->nickname,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'tel_num' => $user->tel_num,
            'introduction' => $user->introduction,
            'city' => $user->city,
            'location' => $user->location,
            'company' => $user->company,
            'username' => $user->username,
            'name' => $user->name,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString()
        ];
    }

    public function includePosts(User $user, ParamBag $params = null)
    {
        if ($params->getIterator()->count() <= 0) {
            $posts = $user->posts;
        } else {
            $this->verificationParams($params, $this->validParams);

            list($limit, $offset) = $params->get('limit') ?? [config('sns.default_per_page'), 1];

            list($orderCol, $orderBy) = $params->get('order') ?? ['created_at', 'desc'];

            if (strtolower($orderBy) == 'asc') {
                $posts = $user->posts
                    ->forPage($limit, $offset)->sortBy($orderCol);
            } else {
                $posts = $user->posts
                    ->forPage($limit, $offset)->sortByDesc($orderCol);
            }
        }
        return $this->collection($posts, new PostTransformer());
    }

    public function includeFollows(User $user, ParamBag $params = null)
    {
        if ($params->getIterator()->count() <= 0) {
            $follows = $user->follows;
        } else {
            $this->verificationParams($params, $this->validParams);

            list($limit, $offset) = $params->get('limit') ?? [config('sns.default_per_page'), 1];

            list($orderCol, $orderBy) = $params->get('order') ?? ['created_at', 'desc'];

            if (strtolower($orderBy) == 'asc') {
                $follows = $user->follows
                    ->forPage($limit, $offset)->sortBy($orderCol);
            } else {
                $follows = $user->follows
                    ->forPage($limit, $offset)->sortByDesc($orderCol);
            }
        }
        return $this->collection($follows, new FollowTransformer());
    }

    public function includeLikes(User $user, ParamBag $params = null)
    {
        if ($params->getIterator()->count() <= 0) {
            $likes = $user->likes;
        } else {
            $this->verificationParams($params, $this->validParams);

            list($limit, $offset) = $params->get('limit') ?? [config('sns.default_per_page'), 1];

            list($orderCol, $orderBy) = $params->get('order') ?? ['created_at', 'desc'];

            if (strtolower($orderBy) == 'asc') {
                $likes = $user->likes
                    ->forPage($limit, $offset)->sortBy($orderCol);
            } else {
                $likes = $user->likes
                    ->forPage($limit, $offset)->sortByDesc($orderCol);
            }
        }
        return $this->collection($likes, new LikeTransformer());
    }
}

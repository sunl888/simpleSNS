<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['posts', 'follows', 'likes'];

    private $validParams = ['limit', 'order'];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'nickname' => $user->nick_name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'tel_num' => $user->tel_num,
            'introduction' => $user->introduction,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString()
        ];
    }

    public function includePosts(User $user, ParamBag $params = null)
    {
        if ($params->getIterator()->count() <= 0) {
            $posts = $user->posts;
        } else {
            verificationParams($params, $this->validParams);

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
            verificationParams($params, $this->validParams);

            list($limit, $offset) = $params->get('limit') ?? [config('sns.default_per_page'), 1];

            list($orderCol, $orderBy) = $params->get('order') ?? ['created_at', 'desc'];

            $follows = $user->follows
                ->take($limit)
                ->skip($offset)
                ->orderBy($orderCol, $orderBy)
                ->get();
        }
        return $this->collection($follows, new FollowTransformer());
    }

    public function includeLikes(User $user, ParamBag $params = null)
    {
        if ($params->getIterator()->count() <= 0) {
            $likes = $user->likes;
        } else {
            verificationParams($params, $this->validParams);

            list($limit, $offset) = $params->get('limit') ?? [config('sns.default_per_page'), 1];

            list($orderCol, $orderBy) = $params->get('order') ?? ['created_at', 'desc'];

            $likes = $user->likes
                ->take($limit)
                ->skip($offset)
                ->orderBy($orderCol, $orderBy)
                ->get();
        }
        return $this->collection($likes, new LikeTransformer());
    }
}

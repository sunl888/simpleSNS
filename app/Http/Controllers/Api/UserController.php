<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers\Api;

use App\Events\FollowedEvent;
use App\Exceptions\PermissionDeniedException;
use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;

class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function toggleFollow(User $user)
    {
        $result = me()->toggleFollow($user);
        if ($result['detached'] == []) {
            event(new FollowedEvent($user, auth()->user()));
        }
    }

    /**
     * 显示指定用户信息.
     * @param User $user
     * @return \App\Support\Response\TransformerResponse
     */
    public function show(User $user)
    {
        return $this->response()->item($user, new UserTransformer());
    }

    /**
     * 更新用户信息.
     *
     * @param User $user
     * @param UserRequest $request
     * @param UserRepository $userRepository
     * @return \App\Support\Response\Response
     * @throws PermissionDeniedException
     */
    public function update(User $user, UserRequest $request, UserRepository $userRepository)
    {
        if ($user->id != auth()->id()) {
            throw new PermissionDeniedException('哼，想修改别人的信息，经过我同意了嘛 ┌( ಠ_ಠ)┘');
        }
        $userRepository->update($request->all(), $user);
        return $this->response()->noContent();
    }
}

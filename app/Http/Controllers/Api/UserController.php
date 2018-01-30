<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\FollowTrait;
use App\Transformers\UserTransformer;

class UserController extends ApiController
{
    use FollowTrait;
    protected static $model;

    public function __construct()
    {
        $this->middleware('auth:api');
        static::$model = User::class;
    }

    /**
     * 显示指定用户信息
     * @param User $user
     * @return \App\Support\Response\TransformerResponse
     */
    public function show(User $user)
    {
        return $this->response()->item($user, new UserTransformer());
    }

    /**
     * 更新用户信息
     *
     * @param User $user
     * @param UserRequest $request
     * @param UserRepository $userRepository
     * @return \App\Support\Response\Response
     */
    public function update(User $user, UserRequest $request, UserRepository $userRepository)
    {
        $userRepository->update($request->all(), $user);
        return $this->response()->noContent();
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;

class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware(['auth:api'])->except(['store']);
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
     * 用户列表
     *
     * @return \App\Support\Response\TransformerResponse
     */
    public function index()
    {
        $users = User::recent()
            ->paginate($this->perPage());
        return $this->response()->paginator($users);
    }

    /**
     * 创建用户
     *
     * @param UserRequest $request
     * @param UserRepository $userRepository
     * @return \App\Support\Response\Response
     */
    public function store(UserRequest $request, UserRepository $userRepository)
    {
        //$userRepository->create($request->all());
        return $this->response()->noContent();
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

    /**
     * 删除指定用户
     *
     * @param User $user
     * @return \App\Support\Response\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        //$user->delete();
        abort('Permission denied', 403);
        return $this->response()->noContent();
    }

}

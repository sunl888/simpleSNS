<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Image;
use App\Models\User;
use App\Services\ImageService;
use App\Transformers\UserTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Overtrue\Socialite\SocialiteManager;

class AuthController extends ApiController
{

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if ($this->beforeValid($credentials) && ($token = $this->attemptLogin($credentials))) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function attemptLogin($credentials)
    {
        // 过滤掉第三方登录的帐号信息
        $credentials['provider'] = null;
        $user = User::byPrimaryKeys($this->username(), $credentials)->first();
        if (is_null($user) || !\Hash::check($credentials['password'], $user->password)) {
            return null;
        }
        return $token = $this->guard()->fromUser($user);
    }

    /**
     * 允许登录的字段
     *
     * @return array
     */
    public function username(): array
    {
        return [
            'tel_num',
            //'email'
        ];
    }

    /**
     * @param array $credentials
     */
    public function beforeValid(array $credentials)
    {
        if (is_null($credentials['password']) || is_null($credentials['username'])) {
            return false;
        }

        return true;
    }

    public function redirectToProvider($driver)
    {
        $response = app(SocialiteManager::class)->driver($driver)->redirect();
        return $response;
    }

    public function handleProviderCallback($driver)
    {
        $userInfo = app(SocialiteManager::class)->driver($driver)->user();
        $user = User::where(['username' => $userInfo->username, 'provider' => strtolower($userInfo->provider)])->first();
        if (is_null($user)) {
            $image = app(ImageService::class)->store($userInfo->getAvatar());
            $data['name'] = $userInfo->getName();
            $data['email'] = $userInfo->getEmail();
            $data['avatar_hash'] = $image->hash;
            $data['username'] = $userInfo->getUsername();
            $data['nickname'] = $userInfo->getNickname();
            $data['provider'] = strtolower($userInfo->getProviderName());
            $data['company'] = $userInfo->getOriginal()['company'];
            $data['location'] = $userInfo->getOriginal()['location'];
            $data['oauth_token'] = json_encode($userInfo->getToken()->toArray());
            $data['last_active_at'] = Carbon::now();

            // 保存用户信息
            $user = User::create($data);

            // 头像存储
            Image::where('hash', $image->hash)->update(['creator_id' => $user->id]);
        }

        if (!$token = $this->guard()->login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return view('logging', ['access_token' => $token, 'expires_in' => $this->guard()->factory()->getTTL() * 60, 'user' => $user]);
    }

    public function guard()
    {
        return Auth::guard();
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return $this->response()->item($this->guard()->user(), new UserTransformer());
    }

    public function logout()
    {
        $this->guard()->logout();
        // TODO 国际化
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

}
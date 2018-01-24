<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Transformers\UserTransformer;
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
        $token = $this->guard()->fromUser($user);
        return $token;
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
        $user = app(SocialiteManager::class)->driver($driver)->user();

        $data['name'] = $user->getName();
        $data['email'] = $user->getEmail();
        $data['avatar'] = $user->getAvatar();
        $data['username'] = $user->getUsername();
        $data['nickname'] = $user->getNickname();
        $data['provider'] = strtolower($user->getProviderName());
        $data['company'] = $user->getOriginal()['company'];
        $data['location'] = $user->getOriginal()['location'];
        $data['oauth_token'] = json_encode($user->getToken()->toArray());

        $credentials = [
            'email' => $data['email'],
            'username' => $data['username'],
            'provider' => $data['provider']
        ];
        $user = User::firstOrCreate($credentials, $data);
        if (!$token = $this->guard()->fromUser($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
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
<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformer;
use App\Http\Controllers\ApiController;
use Overtrue\Socialite\SocialiteManager;

class AuthController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->only('logout', 'me', 'refresh');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if ($this->beforeValid($credentials) && ($token = $this->attemptLogin($credentials))) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * @param array $credentials
     * @return null
     */
    public function attemptLogin(array $credentials)
    {
        // 过滤掉第三方登录的帐号信息
        $credentials['provider'] = null;
        $user = User::byUserNames($this->username(), $credentials)->first();
        if (null === $user || ! \Hash::check($credentials['password'], $user->password)) {
            return;
        }

        return $token = $this->guard()->fromUser($user);
    }

    /**
     * 允许登录的字段.
     *
     * @return array
     */
    public function username(): array
    {
        return config('sns.allow_login_fields', '');
    }

    /**
     * @param array $credentials
     */
    protected function beforeValid(array $credentials)
    {
        if (null === $credentials['password'] || null === $credentials['username']) {
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
        $originalInfo = app(SocialiteManager::class)->driver($driver)->user();
        // 验证用户信息是否存在
        $credentials = [
            'username' => $originalInfo->getUsername(),
            'email'    => $originalInfo->getEmail(),
            'provider' => strtolower($originalInfo->provider),
        ];
        $user = User::where($credentials)->first();
        if (null === $user) {
            $image = app(ImageService::class)->store($originalInfo->getAvatar());
            $data['name'] = $originalInfo->getName() ?? snake_case(str_random(10));
            $data['email'] = $originalInfo->getEmail();
            $data['avatar_hash'] = $image->hash;
            $data['username'] = $originalInfo->getUsername() ?? str_random(10);
            $data['nickname'] = $originalInfo->getNickname() ?? str_random(10);
            $data['provider'] = strtolower($originalInfo->getProviderName());
            $data['company'] = $originalInfo->getOriginal()['company'] ?? '';
            $data['location'] = $originalInfo->getOriginal()['location'] ?? '';
            $data['oauth_token'] = json_encode($originalInfo->getToken()->toArray());
            $data['last_active_at'] = Carbon::now();

            // 保存用户信息
            $user = User::create($data);
            // 头像存储
            Image::where('hash', $image->hash)->update(['creator_id' => $user->id]);
        }

        if (! $token = $this->guard()->login($user)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return view('logging', [
            'access_token' => $token,
            'expires_in'   => $this->guard()->factory()->getTTL() * 60,
            'user'         => $user,
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->factory()->getTTL() * 60,
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

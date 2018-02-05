<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers\Api;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\FieldHasExisted;
use App\Events\ResetPasswrodEvent;
use App\Rules\SMSVerificationCode;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\ApiController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegisterController extends APIController
{
    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 注册.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user);
    }

    /**
     * 重置密码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function resetPassword(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'tel_num'               => ['bail', 'required', 'string', 'regex:/\d{11}/'],
            'sms_verification_code' => ['bail', 'required', new SMSVerificationCode($data['tel_num'])],
            'password'              => ['bail', 'required', 'string', 'min:6'],
        ])->validate();

        $user = User::where(['tel_num' => $data['tel_num'], 'provider' => null])->first();

        if (! $user) {
            throw new ModelNotFoundException('该账号不存在');
        }

        event(new ResetPasswrodEvent($this->update($request->all(), $user)));

        return $this->reseted($request, $data);
    }

    protected function reseted(Request $request, $credentials)
    {
        $credentials = array_only($credentials, ['tel_num', 'password']);

        if ($token = JWTAuth::attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'tel_num' => ['bail', 'required', 'string', 'regex:/\d{11}/', new FieldHasExisted()],
            // TODO 这里如果没有tel_num会报错
            'sms_verification_code' => ['bail', 'required', new SMSVerificationCode($data['tel_num'])],
            //'email' => ['bail', 'required', 'string', 'email', new FieldHasExisted()],
            'password' => ['bail', 'required', 'string', 'min:6'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $userRepository = app(UserRepository::class);

        return $userRepository->create(array_only($data, ['tel_num', 'password']));
    }

    protected function update(array $data, Model $model)
    {
        $userRepository = app(UserRepository::class);

        return $userRepository->update(array_only($data, ['password']), $model);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if ($token = JWTAuth::fromUser($user)) {
            return $this->respondWithToken($token);
        }

        return $this->response()->noContent();
    }

    private function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->factory()->getTTL() * 60,
        ]);
    }
}

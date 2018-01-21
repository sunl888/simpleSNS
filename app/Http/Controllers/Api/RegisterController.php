<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\SendVerificationCodeException;
use App\Http\Controllers\ApiController;
use App\Repositories\UserRepository;
use App\Rules\SMSVerificationCode;
use App\Services\SMSVerificationCode as SMSVerificationCodeService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JWTAuth;
use Log;

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

    public function sendSMSVerificationCode(Request $request)
    {
        $data = $this->validate($request, [
            'tel_num' => ['bail', 'required', 'string', 'regex:/\d{11}/', Rule::unique('users', 'tel_num')]
        ]);

        try {
            app(SMSVerificationCodeService::class)->send($data['tel_num'], config('alidayu.template.user_register'));
        } catch (SendVerificationCodeException $e) {
            // todo 语言包
            Log::error('验证码发送失败！:' . $e->getMessage());
            abort(500, '验证码发送失败！');
        }
        return $this->response()->noContent();
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //dd($this->registered($request, User::find(4)));
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user);
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
            'sms_verification_code' => ['bail', 'required', new SMSVerificationCode($data['tel_num'])],
            'email' => ['bail', 'required', 'string', 'email'],
            'tel_num' => ['bail', 'required', 'string', 'regex:/\d{11}/', 'unique:users'],
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
        return $userRepository->create(array_only($data, ['tel_num', 'email', 'password']));
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
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
}

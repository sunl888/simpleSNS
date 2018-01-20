<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\SendVerificationCodeException;
use App\Http\Controllers\ApiController;
use App\Repositories\UserRepository;
use App\Rules\SMSVerificationCode;
use App\Services\SMSVerificationCode as SMSVerificationCodeService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'sms_verification_code' => ['bail', 'required', new SMSVerificationCode($data['tel_num'])],
            'name' => ['bail', 'required', 'string', 'max:30'],
            'email' => ['bail', 'required', 'string'],
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
        return $userRepository->create(array_only($data, ['name', 'tel_num', 'email', 'password']));
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
        $this->guard()->login($user);
        return $this->response()->noContent();
    }
}

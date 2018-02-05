<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Rules\SMSTemplateHasExisted;
use App\Http\Controllers\ApiController;
use App\Exceptions\SendVerificationCodeException;
use App\Services\SMSVerificationCode as SMSVerificationCodeService;

class SendSMSController extends ApiController
{
    /**
     * @param Request $request
     * @return \App\Support\Response\Response
     * @throws \App\Exceptions\SendSmsFailException
     */
    public function sendSMSVerificationCode(Request $request)
    {
        $data = $this->validate($request, [
            'tel_num'      => ['bail', 'required', 'string', 'regex:/\d{11}/'],
            'sms_template' => ['bail', 'required', 'string', new SMSTemplateHasExisted()],
        ]);

        try {
            app(SMSVerificationCodeService::class)->send($data['tel_num'], config('alidayu.template.' . $data['sms_template']));
        } catch (SendVerificationCodeException $e) {
            abort(500, '验证码发送失败！' . $e->getMessage());
        }

        return $this->response()->noContent();
    }
}

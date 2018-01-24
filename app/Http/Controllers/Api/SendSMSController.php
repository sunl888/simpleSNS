<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/24
 * Time: 18:18
 */

namespace App\Http\Controllers\Api;


use App\Exceptions\SendVerificationCodeException;
use App\Http\Controllers\ApiController;
use App\Rules\SMSTemplateHasExisted;
use App\Services\SMSVerificationCode as SMSVerificationCodeService;
use Illuminate\Http\Request;


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
            'tel_num' => ['bail', 'required', 'string', 'regex:/\d{11}/'],
            'sms_template' => ['bail', 'required', 'string', new SMSTemplateHasExisted()]
        ]);

        try {
            app(SMSVerificationCodeService::class)->send($data['tel_num'], config('alidayu.template.' . $data['sms_template']));
        } catch (SendVerificationCodeException $e) {
            abort(500, '验证码发送失败！' . $e->getMessage());
        }
        return $this->response()->noContent();
    }
}
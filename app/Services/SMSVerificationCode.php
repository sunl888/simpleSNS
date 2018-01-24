<?php

namespace App\Services;

use App\Exceptions\GenerateVerificationCodeException;
use App\Repositories\VerificationCodeRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher;

/**
 * 短信验证码
 * Class SMSVerificationCode
 * @package App\Services
 */
class SMSVerificationCode
{
    protected $hasher;
    protected $config;
    protected $verificationCodeRepository;

    public function __construct(VerificationCodeRepository $verificationCodeRepository, Hasher $hasher, $config)
    {
        $this->hasher = $hasher;
        $this->config = $config;
        $this->verificationCodeRepository = $verificationCodeRepository;
    }

    public function check($phoneNumber, $value)
    {
        $verificationCodeModel = $this->verificationCodeRepository->retrieveByTelNum($phoneNumber);
        if (is_null($verificationCodeModel) || Carbon::now()->diffInSeconds($verificationCodeModel['created_at'], true) > $this->config['term_of_validity'])
            // 验证码不存在或者验证码已经过期
            return false;

        $hashedCode = $verificationCodeModel['hashed_code'];

        if ($this->hasher->check(strtolower($value), $hashedCode)) {
            $this->verificationCodeRepository->delete($phoneNumber);
            return true;
        }
        // 验证码不匹配
        return false;
    }

    /**
     * @param $phoneNumber
     * @param $config
     * @throws \App\Exceptions\SendSmsFailException
     */
    public function send($phoneNumber, $config)
    {
        list($signName, $templateCode, $outId) = array_values($config);

        $this->sendVerificationCode($phoneNumber, $this->generateVerificationCode($phoneNumber), $signName, $templateCode, $outId);
    }

    /**
     * @param $phoneNumber
     * @param $verificationCode
     * @param $signName
     * @param $templateCode
     * @param null $outId
     * @throws \App\Exceptions\SendSmsFailException
     */
    protected function sendVerificationCode($phoneNumber, $verificationCode, $signName, $templateCode, $outId = null)
    {
        /*$client = new Client($this->config);
        $sendSms = new SendSms();
        $sendSms->setPhoneNumbers($phoneNumber);
        $sendSms->setSignName($signName);
        $sendSms->setTemplateCode($templateCode);
        $sendSms->setTemplateParam(['code' => $verificationCode]);
        $sendSms->setOutId($outId);

        $res = $client->execute($sendSms);

        if ($res->Code !== 'OK') {
            throw new SendVerificationCodeException($res->Message);
        }*/
        $this->verificationCodeRepository->create([
            'tel_num' => $phoneNumber,
            'hashed_code' => $this->hasher->make(strtolower($verificationCode))
        ]);
        app(SendSmsService::class)->send($phoneNumber, ['code' => $verificationCode], $signName, $templateCode, $outId);
    }

    protected function generateVerificationCode($phoneNumber)
    {
        $verificationCodeModel = $this->verificationCodeRepository->retrieveByTelNum($phoneNumber);

        if ($verificationCodeModel) {
            $diffSeconds = Carbon::now()->diffInSeconds($verificationCodeModel['created_at'], true);
            if ($diffSeconds < $this->config['interval'])
                // todo 语言包
                throw new GenerateVerificationCodeException(sprintf('验证码已经发送！请 %d 秒后重试！', $this->config['interval'] - $diffSeconds));
        }

        $code = get_mobile_code(5);

        return $code;
    }
}

<?php

namespace App\Services;

use App\Exceptions\GenerateVerificationCodeException;
use App\Exceptions\SendSmsFailException;
use App\Exceptions\SendVerificationCodeException;
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
        if (is_null($verificationCodeModel) || Carbon::now()->diffInSeconds($verificationCodeModel->created_at, true) > $this->config['term_of_validity'])
            // 验证码不存在或者验证码已经过期
            return false;

        $hashedCode = $verificationCodeModel->hashed_code;
        $this->verificationCodeRepository->delete($phoneNumber);
        return $this->hasher->check(strtolower($value), $hashedCode);
    }

    public function send($phoneNumber, $config)
    {
        list($signName, $templateCode, $outId) = array_values($config);
        $this->sendVerificationCode($phoneNumber, $this->generateVerificationCode($phoneNumber), $signName, $templateCode, $outId);
    }

    protected function sendVerificationCode($phoneNumber, $verificationCode, $signName, $templateCode, $outId = null)
    {
        try {
            app(SendSmsService::class)->send($phoneNumber, ['code' => $verificationCode], $signName, $templateCode, $outId);
        } catch (SendSmsFailException $e) {
            throw new SendVerificationCodeException($e->getMessage());
        }
        $this->verificationCodeRepository->create([
            'tel_num' => $phoneNumber,
            'hashed_code' => $this->hasher->make(strtolower($verificationCode))
        ]);
    }

    protected function generateVerificationCode($phoneNumber)
    {
        $verificationCodeModel = $this->verificationCodeRepository->retrieveByTelNum($phoneNumber);
        if ($verificationCodeModel) {
            $diffSeconds = Carbon::now()->diffInSeconds($verificationCodeModel->created_at, true);
            if ($diffSeconds < $this->config['interval'])
                // todo 语言包
                throw new GenerateVerificationCodeException(sprintf('验证码已经发送！请 %d 秒后重试！', $this->config['interval'] - $diffSeconds));
        }

        $code = rand(1000, 9999);

        return $code;
    }
}

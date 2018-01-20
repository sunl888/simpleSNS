<?php

namespace App\Rules;

use App\Services\SMSVerificationCode as SMSVerificationCodeService;
use Illuminate\Contracts\Validation\Rule;

class SMSVerificationCode implements Rule
{
    protected $phoneNumber;

    public function __construct($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return app(SMSVerificationCodeService::class)->check($this->phoneNumber, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // todo 语言包
        return '短信验证码有误';
    }
}

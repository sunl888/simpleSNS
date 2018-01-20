<?php

namespace App\Exceptions;

class SendVerificationCodeException extends SendSmsFailException
{
    public function __construct($message = null, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        parent::__construct($message, 500, $previous);
    }
}
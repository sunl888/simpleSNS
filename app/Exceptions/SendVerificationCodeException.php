<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class SendVerificationCodeException extends HttpException
{
    public function __construct($message = null, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        parent::__construct(500, $message, $previous, $headers, $code);
    }
}
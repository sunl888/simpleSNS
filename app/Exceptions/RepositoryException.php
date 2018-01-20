<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class RepositoryException extends HttpException
{
    public function __construct($statusCode, $message = null, \Exception $previous = null, array $headers = array(), int $code = 0)
    {
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}

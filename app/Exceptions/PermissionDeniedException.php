<?php

/*
 * add .styleci.yml
 */

namespace App\Exceptions;

use Exception;
use Throwable;

class PermissionDeniedException extends Exception
{
    public function __construct(string $message = '', int $code = 401, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

<?php

/*
 * add .styleci.yml
 */

namespace App\Exceptions;

use Exception;
use App\Exceptions\Debug\WantsJsonRequest;
use Illuminate\Auth\AuthenticationException;
use App\Exceptions\Contract\MessageBagErrors;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (config('app.debug')) {
            $request = new WantsJsonRequest($request);
        }

        return parent::render($request, $exception);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json($this->errorFormat(new ResourceException(null, $exception->errors())), $exception->status);
    }

    protected function errorFormat(Exception $e)
    {
        $errorFormat = config('api.errorFormat');
        $statusCode = $this->getStatusCode($e);
        if (! $message = $e->getMessage()) {
            $message = sprintf('%d %s', $statusCode, isset(Response::$statusTexts[$statusCode]) ? Response::$statusTexts[$statusCode] : 'Unknown status code');
        }

        $replacements = [
            ':message'     => $message,
            ':status_code' => $statusCode,
        ];

        if ($e instanceof MessageBagErrors && $e->hasErrors()) {
            $replacements[':errors'] = $e->getErrors();
        }

        if ($code = $e->getCode()) {
            $replacements[':code'] = $code;
        }
        if (config('app.debug')) {
            $replacements[':debug'] = [
                'line'  => $e->getLine(),
                'file'  => $e->getFile(),
                'class' => get_class($e),
                'trace' => explode("\n", $e->getTraceAsString()),
            ];
        }
        array_walk_recursive($errorFormat, function (&$value, $key) use ($e, $replacements) {
            if (starts_with($value, ':') && isset($replacements[$value])) {
                $value = $replacements[$value];
            }
        });

        return $this->recursivelyRemoveEmptyReplacements($errorFormat);
    }

    protected function getStatusCode(Exception $exception)
    {
        return $this->isHttpException($exception) ? $exception->getStatusCode() : 500;
    }

    protected function recursivelyRemoveEmptyReplacements(array $input)
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = $this->recursivelyRemoveEmptyReplacements($value);
            }
        }

        return array_filter($input, function ($value) {
            if (is_string($value)) {
                return ! starts_with($value, ':');
            }

            return true;
        });
    }

    protected function convertExceptionToArray(Exception $e)
    {
        return $this->errorFormat($e);
    }

    /**
     * JWT 认证时token过期返回 JSON,而不redirect to login.
     *
     * @param \Illuminate\Http\Request $request
     * @param AuthenticationException $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()->guest(route('login'));
    }
}

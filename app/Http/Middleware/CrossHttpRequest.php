<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Middleware;

use Closure;

class CrossHttpRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 200);
        } else {
            $response = $next($request);
        }
        if (!method_exists($response, 'header')) {
            return $response;
        }
        $response->headers->set('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS');
        $response->headers->set(
            'Access-Control-Allow-Headers',
            'Content-Type, Content-Length, Authorization, Accept, X-Requested-With, Token'
        );
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Max-Age', 86400);

        return $response;
    }
}

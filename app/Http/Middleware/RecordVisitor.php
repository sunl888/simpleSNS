<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Middleware;

use Closure;
use App\Services\VisitorService;

class RecordVisitor
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
        app(VisitorService::class)->record();

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Services\VisitorService;
use Closure;

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

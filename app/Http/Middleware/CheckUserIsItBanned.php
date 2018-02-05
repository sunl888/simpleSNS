<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Middleware;

use Auth;
use Closure;
use Request;

class CheckUserIsItBanned
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_banned == 'yes' && Request::is('user-banned') == false) {
            return redirect('/user-banned');
        }

        return $next($request);
    }
}

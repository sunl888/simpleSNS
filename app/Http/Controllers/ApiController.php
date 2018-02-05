<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers;

use App\Support\Response\Response;

class ApiController extends Controller
{
    public function response()
    {
        return app(Response::class);
    }
}

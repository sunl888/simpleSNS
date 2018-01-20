<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/20
 * Time: 21:04
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
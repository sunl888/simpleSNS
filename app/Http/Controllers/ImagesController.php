<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers;

use League\Glide\Server;
use Illuminate\Http\Request;
use League\Glide\Filesystem\FileNotFoundException;

class ImagesController extends Controller
{
    public function show(Server $server, $path, Request $request)
    {
        try {
            return $server->getImageResponse(
                substr($path, 0, 2) . DIRECTORY_SEPARATOR . $path,
                $request->all());
        } catch (FileNotFoundException $e) {
            abort(404, '图片不存在');
        }
    }
}

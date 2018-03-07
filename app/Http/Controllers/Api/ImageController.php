<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\ImageService;
use App\Http\Controllers\APIController;
use App\Exceptions\ImageUploadException;

class ImageController extends APIController
{
    protected $imageService;

    public function __construct()
    {
        //$this->middleware('auth:api');
        $this->imageService = app(ImageService::class);
    }

    public function upload(Request $request)
    {
        $image = $request->file($this->imageService->uploadKey());

        if (null === $image || ! $image->isValid()) {
            $error = $image ? $image->getErrorMessage() : '图片上传失败';
            throw new ImageUploadException($error);
        }

        $imageModel = $this->imageService->store($image, auth()->id());

        return [
            'image_hash' => $imageModel->hash,
            'image_url'  => image_url($imageModel->hash, $imageModel->ext),
        ];
    }
}

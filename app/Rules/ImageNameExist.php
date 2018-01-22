<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Storage;

class ImageNameExist implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $config = config('images');
        $imageRealPath = $config['source_path_prefix']. DIRECTORY_SEPARATOR . substr($value, 0, 2) . DIRECTORY_SEPARATOR . $value;
        return Storage::disk($config['source_disk'])->exists($imageRealPath);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '上传的图片不存在';
    }
}

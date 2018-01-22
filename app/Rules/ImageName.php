<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageName implements Rule
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
        return preg_match('/[a-zA-Z0-9]{32}\.[a-zA-Z0-9]+/', $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '图片名称不正确';
    }
}

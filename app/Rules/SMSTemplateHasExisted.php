<?php

/*
 * add .styleci.yml
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SMSTemplateHasExisted implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $templates = config('alidayu.template', null);

        if ($templates == null) {
            return false;
        }

        return array_key_exists($value, $templates);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //This SMStemplate does not exist
        return 'This :attribute does not exist.';
    }
}

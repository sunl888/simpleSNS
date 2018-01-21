<?php

namespace App\Exceptions\Contract;

interface MessageBagErrors
{
    /**
     * Get the errors message bag.
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors();

    /**
     * Determine if message bag has any errors.
     *
     * @return bool
     */
    public function hasErrors();
}

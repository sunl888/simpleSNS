<?php

namespace App\Exceptions\Debug;


use Illuminate\Http\Request;

class WantsJsonRequest
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the current request probably expects a JSON response.
     *
     * @return bool
     */
    public function expectsJson()
    {
        return $this->has('wants_json') || $this->request->expectsJson();
    }

    public function __call($method, $arguments)
    {
        return $this->request->$method(...$arguments);
    }

    public function __set($name, $value)
    {
        $this->request->$name = $value;
    }

    public function __get($name)
    {
        return $this->request->$name;
    }
}

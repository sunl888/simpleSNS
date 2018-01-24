<?php

namespace App\Services;

use Cache;

class SettingCacheService
{

    private $allCaches = null;

    protected function cacheKay()
    {
        return 'cache:all';
    }

    public function all()
    {
        if (is_null($this->allCaches)) {
            $this->allCaches = Cache::remember($this->cacheKay(), config('cache.ttl'));
        }
        return $this->allCaches;
    }

    public function get($name)
    {
        return $this->all()->get($name);
    }

    public function clearCache()
    {
        return Cache::forget($this->cacheKay());
    }
}

<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use Cache;

class SettingCacheService
{

    private $allSettings = null;

    public function get($name)
    {
        return $this->all()->get($name);
    }

    public function all()
    {
        if (is_null($this->allSettings)) {
            $this->allSettings = Cache::remember($this->cacheKay(), config('cache.ttl'), function () {
                return app(SettingRepository::class)->allSettingWithoutCache();
            });
        }
        return $this->allSettings;
    }

    protected function cacheKay()
    {
        return 'setting:all';
    }

    public function clearCache()
    {
        return Cache::forget($this->cacheKay());
    }
}

<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use Cache;

class SettingCacheService
{

    private $allSettings = null;

    protected function cacheKay()
    {
        return 'setting:all';
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

    public function get($name)
    {
        return $this->all()->get($name);
    }

    public function clearCache()
    {
        return Cache::forget($this->cacheKay());
    }
}

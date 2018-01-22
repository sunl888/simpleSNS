<?php

namespace App\Services;

use App\Models\Visitor;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use stdClass;

class VisitorService
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function record()
    {
        $ip = $this->request->ip();
        $visitor = $this->getVisitorByIpWithinToday($ip);
        if (is_null($visitor)) {
            // create
            Visitor::create([
                'ip' => $ip,
                'views' => 1,
                'referring_site' => $this->request->header('referer', null)
            ]);
        } else {
            // increment
            // $this->increment($visitor);
        }
    }

    public function getVisitorByIpWithinToday($ip)
    {
        return Visitor::where('ip', $ip)->withinToday()->first();
    }

    public function getRecentlyPVUVFromCache()
    {
        // todo 14 放到配置文件中
        $visitorRecordDays = 30;
        $today = Carbon::today();
        // 获取应该 cache 的日期
        $shouldCacheDates = [];
        $day = $today->copy();
        for ($i = $visitorRecordDays; $i > 0; $i--) {
            $shouldCacheDates[] = $day->copy()->subDays($i);
        }

        if (!Cache::has('visitor::all_cached_dates')) {

            // 生成所有 PVUV
            foreach ($shouldCacheDates as $date) {
                Cache::forever($this->getCacheKey($date), $this->getPVUVByDateWithoutCache($date));
            }

            Cache::forever('visitor::all_cached_dates', $shouldCacheDates);

        } else {
            $allCachedDates = Cache::get('visitor::all_cached_dates');

            $needResetCache = false;
            foreach ($shouldCacheDates as $shouldCacheDay) {
                if (!in_array($shouldCacheDay, $allCachedDates)) {
                    // put cache
                    Cache::forever($this->getCacheKey($shouldCacheDay), $this->getPVUVByDateWithoutCache($shouldCacheDay));

                    if (!$needResetCache) $needResetCache = true;
                }
            }

            foreach ($allCachedDates as $cachedDay) {
                if (!in_array($cachedDay, $shouldCacheDates)) {
                    // forget cache
                    Cache::forget($this->getCacheKey($cachedDay));
                    if (!$needResetCache) $needResetCache = true;
                }
            }

            if ($needResetCache) {
                Cache::forget('visitor::all_cached_dates');
                Cache::forever('visitor::all_cached_dates', $shouldCacheDates);
            }

        }

        $PVUVData = [];
        foreach ($shouldCacheDates as $date) {
            $PVUVData[] = $this->getPVUVByDateFromCache($date);
        }
        return $PVUVData;
    }

    private function getCacheKey($date)
    {
        if ($date instanceof Carbon) {
            $date = $date->toDateString();
        }
        return 'visitor::pv_uv::' . $date;
    }

    public function getPVUVByDateWithoutCache(Carbon $date)
    {
        return [
            'unique_visitor' => Visitor::withinOneday($date)->count()
        ];
    }

    public function getPVUVByDateFromCache(Carbon $date)
    {
        $cacheKey = $this->getCacheKey($date);
        if (!Cache::has($cacheKey)) {
            Cache::put($cacheKey, config('cache.ttl'));
        }
        return Cache::get($cacheKey) ?: new stdClass();
    }

    protected function increment(Visitor $visitor)
    {
        return $visitor->increment('views');
    }


}

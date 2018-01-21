<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/20
 * Time: 20:34
 */

use App\Repositories\SettingRepository;
use App\Services\SettingCacheService;
use GuzzleHttp\Exception\TransferException;

if (!function_exists('toIso8601String')) {
    function toIso8601String($date)
    {
        if (is_null($date)) {
            return $date;
        }
        $carbon = \Carbon\Carbon::parse($date);
        return $carbon->toIso8601String();
    }
}


if (!function_exists('setting')) {
    /**
     * 获取或设置网站设置
     * 获取: setting('setting_name', 'default_value');
     * 设置: 1. setting(['setting_name1' => 'value1', 'setting_name2' => 'value2']);
     *      2. setting(['setting_name1' => ['value' => 'value_test', 'is_system' => true]]);
     * @param null $name
     * @param null $default
     * @return SettingCacheService|\Illuminate\Foundation\Application|mixed|null|void
     */
    function setting($name = null, $default = null)
    {
        if (is_null($name)) {
            return app(SettingCacheService::class);
        }

        if (is_array($name)) {
            return app(SettingRepository::class)->set($name);
        }

        $setting = app(SettingCacheService::class)->get($name);

        if (!is_null($setting)) {
            return $setting->value;
        }
        return value($default);
    }
}

/**
 * transformer params validation
 */
if (!function_exists('verificationParams')) {
    function verificationParams($params, $validParams)
    {
        $usedParams = array_keys(iterator_to_array($params));
        if ($invalidParams = array_diff($usedParams, $validParams)) {
            throw new TransferException(sprintf(
                'Invalid param(s): "%s". Valid param(s): "%s"',
                implode(',', $usedParams),
                implode(',', $validParams)
            ));
        }
    }
}
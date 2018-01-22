<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/20
 * Time: 20:34
 */

use App\Repositories\SettingRepository;
use App\Services\SettingCacheService;

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

if (!function_exists('image_url')) {

    function image_url($imageId, $style = null, $default = null)
    {
        static $config = [];

        if (is_null($imageId)) {
            return value($default);
        }

        if (empty($config))
            $config = config('images');

        if ($config['source_disk'] == 'local') {

            $parameters = ['image' => $imageId];

            if (is_array($style)) {
                $parameters = array_merge($parameters, $style);
            } elseif (is_string($style)) {
                $parameters['p'] = $style;
            }

            return route(config('images.route_name'), $parameters);

        } else {
            $path = $config['source_path_prefix'] . '/' . substr($imageId, 0, 2) . '/' . $imageId;

            if (is_array($style)) {
                $style = array_merge($config['default_style'], $style);
            } elseif (isset($config['presets'][$style])) {
                $style = array_merge($config['default_style'], $config['presets'][$style]);
            } else {
                $style = null;
            }

            if (!empty($style)) {

                if (isset($style['q'])) {
                    $q = "q/{$style['q']}|imageslim";
                } else {
                    $q = '';
                }
                // $parameters = "?imageView2/1/w/{$style['w']}/h/{$style['h']}" . $q;

                $parameters = '?imageView2/1/' . (isset($style['w']) ? "w/{$style['w']}/" : '') . (isset($style['h']) ? "h/{$style['h']}/" : '') . $q;

            } else {
                $parameters = '';
            }

            return Storage::disk($config['source_disk'])->url($path) . $parameters;
        }

    }

}

if (!function_exists('clean')) {
    function clean($html, $config = null)
    {
        return app(HTMLPurifier::class)->purify($html, $config);
    }
}


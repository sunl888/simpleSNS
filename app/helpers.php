<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/20
 * Time: 20:34
 */

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
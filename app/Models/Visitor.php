<?php

namespace App\Models;


use Carbon\Carbon;

class Visitor extends BaseModel
{
    protected $fillable = ['ip', 'views', 'referring_site'];

    public function scopeRange($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeWithinOneday($query, Carbon $date)
    {
        return $query->range($date->copy()->startOfDay(), $date->copy()->endOfDay());
    }

    public function scopeWithinToday($query)
    {
        return $query->withinOneday(Carbon::today());
    }
}

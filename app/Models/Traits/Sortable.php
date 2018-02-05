<?php

/*
 * add .styleci.yml
 */

namespace App\Models\Traits;

trait Sortable
{
    /**
     * 按 created_at 降序排序.
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * 按 created_at 升序排序.
     * @param $query
     * @return mixed
     */
    public function scopeAncient($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    /**
     * 按 order 降序排序.
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'desc');
    }
}

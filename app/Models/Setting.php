<?php

namespace App\Models;

use App\Models\Traits\Listable;
use App\Models\Traits\Typeable;
use App\Observers\ClearSettingCache;
use Illuminate\Database\Eloquent\Builder;

class Setting extends BaseModel implements InterfaceTypeable
{
    use Typeable, Listable;

    protected static $allowSortFields = ['name', 'value', 'description', 'type_name'];
    protected static $allowSearchFields = ['name', 'value', 'description'];
    protected $fillable = ['name', 'value', 'description', 'type_name', 'is_system', 'creator_id'];
    protected $casts = [
        'is_visible' => 'boolean'
    ];

    /**
     * 数据模型的启动方法
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('notSystem', function (Builder $builder) {
            $builder->where('is_system', false);
        });

        static::observe(ClearSettingCache::class);
    }

}

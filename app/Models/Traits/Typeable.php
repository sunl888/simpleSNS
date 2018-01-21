<?php

namespace App\Models\Traits;

use App\Models\Type;

trait Typeable
{
    public function scopeByType($query, $type)
    {
        if ($type instanceof Type) {
            $typeName = $type->name;
        } elseif (is_array($type)) {
            $typeName = $type['name'];
        } else {
            $typeName = $type;
        }
        if ($typeName) {
            $query->where('type_name', $typeName);
        }
        return $query;
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'name', 'type_name');
    }
}

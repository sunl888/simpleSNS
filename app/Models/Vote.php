<?php

namespace App\Models;


class Vote extends BaseModel
{
    protected $fillable = ['user_id', 'votable', 'type'];

    public function votable()
    {
        return $this->morphTo();
    }
}

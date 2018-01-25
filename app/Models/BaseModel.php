<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function slugMode()
    {
        return config('sns.default_slug_mode');
    }
}

<?php

/*
 * add .styleci.yml
 */

namespace App\Models;

class Feedback extends BaseModel
{
    protected $fillable = ['user_id', 'content'];
}

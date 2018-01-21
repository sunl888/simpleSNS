<?php

namespace App\Models;


class VerificationCode extends BaseModel
{
    public $timestamps = false;

    public $dates = ['created_at'];

    protected $fillable = ['tel_num', 'hashed_code', 'created_at'];

}

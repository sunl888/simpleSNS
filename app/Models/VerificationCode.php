<?php

namespace App\Models;

/**
 * Class VerificationCode
 * @package App\Models
 * @deprecated 此 Model 已经废弃, 不推荐使用
 */
class VerificationCode extends BaseModel
{
    public $timestamps = false;

    public $dates = ['created_at'];

    protected $fillable = ['tel_num', 'hashed_code', 'created_at'];

}

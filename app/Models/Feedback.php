<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/21
 * Time: 20:00
 */

namespace App\Models;


class Feedback extends BaseModel
{
    protected $fillable = ['user_id', 'content',];

}
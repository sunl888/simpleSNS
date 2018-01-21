<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/21
 * Time: 20:00
 */

namespace App\Models;


class Follow extends BaseModel
{
    protected $fillable = ['user_id', 'follow_user_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // 关注的用户个人信息
    public function follow()
    {
        return $this->hasOne(User::class, 'id', 'follow_user_id');
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/21
 * Time: 20:16
 */

namespace App\Models;

class Comment extends BaseModel
{
    protected $fillable = ['user_id', 'post_id', 'parent_id', 'likes', 'content', 'is_show'];

}
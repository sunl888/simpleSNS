<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/21
 * Time: 21:04
 */

namespace App\Transformers;


use App\Models\Like;
use League\Fractal\TransformerAbstract;

class LikeTransformer extends TransformerAbstract
{

    protected $availableIncludes = [];

    private $validParams = [];

    public function transform(Like $user)
    {
        return [
            'id' => $user->id,
            'nickname' => $user->nick_name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'tel_num' => $user->tel_num,
            'introduction' => $user->introduction,
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString()
        ];
    }
}
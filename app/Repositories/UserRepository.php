<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2018/1/20
 * Time: 21:06
 */

namespace App\Repositories;

use App\Models\User;
use Hash;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    public function preCreate(array &$data)
    {
        return $this->filterData($data);
    }

    public function filterData(array &$data)
    {
        if (isset($data['name']))
            $data['name'] = e($data['name']);
        if (isset($data['email']))
            $data['email'] = e($data['email']);
        if (isset($data['password']))
            $data['password'] = Hash::make($data['password']);
        if (isset($data['introduction']))
            $data['introduction'] = e($data['introduction']);
        return $data;
    }

    public function preUpdate(array &$data)
    {
        return $this->filterData($data);
    }

}

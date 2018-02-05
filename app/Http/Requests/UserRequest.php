<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Requests;

use App\Rules\FieldHasExisted;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            case 'POST':
                return [];
                break;
            case 'PUT':
            case 'PATCH':
                return [
                    'email'   => ['bail', 'nullable', 'string', 'email', new FieldHasExisted()], // email
                    'tel_num' => ['bail', 'nullable', 'string', 'regex:/\d{11}/', new FieldHasExisted()], // 手机号码
                    //'password' =>     ['bail', 'nullable', 'string', 'min:6'],// 密码
                    'nickname'     => ['bail', 'nullable', 'string', 'min:4'], // 昵称
                    'avatar_hash'  => 'bail|nullable|size:32|exists:images,hash',
                    'introduction' => ['bail', 'nullable', 'string', 'max:128'], // 简介
                    'city'         => ['bail', 'nullable', 'string', 'between:3,128'], // 所属城市
                    'location'     => ['bail', 'nullable', 'string'], // 地址
                    'company'      => ['bail', 'nullable', 'string'], // 公司
                    //'username' =>     ['bail', 'nullable', 'string'],
                    'name' => ['bail', 'nullable', 'string'], // 真实姓名
                ];
            default:
                return [];
                break;
        }
    }
}

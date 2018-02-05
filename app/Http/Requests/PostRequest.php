<?php

/*
 * add .styleci.yml
 */

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Validation\Rule;

class PostRequest extends Request
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
                return [];
            case 'POST':
                return [
                    //'title'   => ['required', 'string', 'between:1,100'],
                    // 内容 必填
                    'content' => ['bail', 'required', 'string'],
                    // 封面 可选
                    'cover'        => ['bail', 'nullable', 'exists:images,hash'],
                    // 状态 可选 publish、draft
                    'status' => ['bail', 'nullable', Rule::in([Post::STATUS_PUBLISH, Post::STATUS_DRAFT])],
                    // 收藏集ID 必填
                    'collection_id' => ['bail', 'required', 'integer', Rule::exists('collections', 'id')],
                    // 发布时间（用于发定时文章，类似QQ空间）
                    'published_at' => ['bail', 'nullable', 'date'],
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    //'title'   => ['nullable', 'string', 'between:1,100'],
                    'content' => ['nullable', 'string'],
                    'cover'        => ['bail', 'nullable', 'exists:images,hash'],
                    'status' => ['bail', 'nullable', Rule::in([Post::STATUS_PUBLISH, Post::STATUS_DRAFT])],
                    'collection_id' => ['bail', 'nullable', 'integer', Rule::exists('collections', 'id')],
                    'published_at' => ['bail', 'nullable', 'date'],
                ];
            default:
                return [];
                break;
        }
    }
}

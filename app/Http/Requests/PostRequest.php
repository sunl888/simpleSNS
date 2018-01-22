<?php

namespace App\Http\Requests;

use App\Models\Post;
use App\Rules\ImageName;
use App\Rules\ImageNameExist;
use App\Rules\TagExist;
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
                    'title' => ['required', 'string', 'between:1,100'],
                    'excerpt' => ['nullable', 'string', 'between:1,512'],
                    'content' => ['required', 'string'],
                    // todo 图片尺寸验证
                    'cover' => ['bail', 'nullable', new ImageName(), new ImageNameExist()],
                    'status' => ['nullable', Rule::in([Post::STATUS_PUBLISH, Post::STATUS_DRAFT])],
                    'order' => ['nullable', 'integer'],
                    'category_id' => ['bail', 'required', 'integer', Rule::exists('categories', 'id')],
                    'published_at' => ['nullable', 'date'],
                    'tag_ids' => ['nullable', 'array',new TagExist()],
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'title' => ['nullable', 'string', 'between:1,100'],
                    'excerpt' => ['nullable', 'string', 'between:1,512'],
                    'content' => ['nullable', 'string'],
                    // todo 图片尺寸验证
                    'cover' => ['bail', 'nullable', new ImageName(), new ImageNameExist()],
                    'status' => ['nullable', Rule::in([Post::STATUS_PUBLISH, Post::STATUS_DRAFT])],
                    'order' => ['nullable', 'integer'],
                    'category_id' => ['bail', 'nullable', 'integer', Rule::exists('categories', 'id')],
                    'published_at' => ['nullable', 'date'],
                    'tag_ids' => ['nullable', 'array',new TagExist()],
                ];
            default:
                return [];
                break;
        }
    }
}

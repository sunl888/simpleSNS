<?php

namespace App\Http\Requests;

class CollectionRequest extends Request
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
                    'title' => ['bail', 'required', 'string', 'between:1,20'],
                    'introduction' => ['bail', 'required', 'string', 'between:1,100'],
                    'color' => ['bail', 'required', 'string'],
                    'cover' => ['bail', 'required', 'exists:images,hash'],
                    'user_id' => ['bail', 'required', 'unique:user,id'],
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'title' => ['bail', 'nullable', 'string', 'between:1,20'],
                    'introduction' => ['bail', 'nullable', 'string', 'between:1,100'],
                    'color' => ['bail', 'nullable', 'string'],
                    'cover' => ['bail', 'nullable', 'exists:images,hash'],
                    'user_id' => ['bail', 'nullable', 'unique:user,id'],
                ];
            default:
                return [];
                break;
        }
    }
}

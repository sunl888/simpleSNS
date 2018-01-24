<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Category;
use App\Rules\ImageName;
use App\Rules\ImageNameExist;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class CategoryRequest extends Request
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
        return [
            'type' => ['required', Rule::in([Category::TYPE_POST, Category::TYPE_PAGE, Category::TYPE_LINK, Category::TYPE_CHANNEL])],
            'image' => ['bail', 'nullable', new ImageName(), new ImageNameExist()],
            'parent_id' => ['bail', 'sometimes', 'integer', 'min:0'],
            'cate_name' => ['bail', 'required', 'string', 'between:2,30', 'unique:categories'],
            'description' => ['nullable', 'string', 'between:2,500'],
            // 'url' => ['required_if:type,' . Category::TYPE_LINK, 'url'],
            'url' => [],
            // 'is_target_blank' => ['required_if:type,' . Category::TYPE_LINK, 'boolean'],
            'is_target_blank' => [],
            'is_nav' => ['sometimes', 'boolean'],
            'order' => ['nullable', 'integer'],
            // 'page_template' => ['required_if: type,' . Category::TYPE_PAGE, 'string', 'between:1,30'],
            'page_template' => [],
            // 'list_template' => ['required_if:type,' . Category::TYPE_POST, 'string', 'between:1,30'],
            'list_template' => [],
            // 'content_template' => ['required_if:type,' . Category::TYPE_POST, 'string', 'between:1,30']
            'content_template' => [],
            // 'channel_template' => ['required_if:type,' . Category::TYPE_CHANNEL, 'string', 'between:1,30']
            'channel_template' => [],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->sometimes('parent_id', 'exists:categories,id', function ($input) {
            return $input->parent_id > 0;
        });

        $validator->sometimes('url', 'required|url', function ($input) {
            return $input->type == Category::TYPE_LINK;
        });

        $validator->sometimes('is_target_blank', 'required|boolean', function ($input) {
            return $input->type == Category::TYPE_LINK;
        });

        $validator->sometimes('page_template', 'required|string|between:1,30', function ($input) {
            return $input->type == Category::TYPE_PAGE;
        });

        $validator->sometimes('list_template', 'required|string|between:1,30', function ($input) {
            return $input->type == Category::TYPE_POST;
        });

        $validator->sometimes('content_template', 'required|string|between:1,30', function ($input) {
            return $input->type == Category::TYPE_POST;
        });

        $validator->sometimes('channel_template', 'required|string|between:1,30', function ($input) {
            return $input->type == Category::TYPE_CHANNEL;
        });

        return $validator;
    }
}

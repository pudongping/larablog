<?php

namespace App\Http\Requests\Admin\Article;

use App\Http\Requests\Request;

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
        $rules = [
            'store' => [
                'name'         => 'required|between:1,6',
                'description'  => 'required|between:1,15',
            ],
            'update' => [
                'name'         => 'required|between:1,6',
                'description'  => 'required|between:1,15',
            ],
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'name.required'        => '分类名称不能为空。',
            'name.between'         => '分类名称必须介于 1 - 6 个字符之间。',
            'description.required' => '分类描述不能为空。',
            'description.between'  => '分类描述必须介于 1 - 15 个字符之间。',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

<?php

namespace App\Http\Requests\Admin\Article;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;
use App\Models\Portal\Article\Tag;

class TagRequest extends Request
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
                'name'         => 'required|between:1,20|unique:tags',
                'description'  => 'required|between:1,50',
                'btn_class'    => [
                    'required',
                    Rule::in(Tag::$allowedBtnClass),
                    ],
                'order'        => 'nullable|integer',
            ],
            'update' => [
                'name'         => [
                    'required',
                    'between:1,20',
                    Rule::unique('tags')->ignore($this->input('id')),
                    ],
                'description'  => 'required|between:1,50',
                'btn_class'    => [
                    'required',
                    Rule::in(Tag::$allowedBtnClass),
                ],
                'order'        => 'nullable|integer',
            ],
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'name.required'        => '标签名称不能为空。',
            'name.between'         => '标签名称必须介于 1 - 20 个字符之间。',
            'name.unique'          => '标签名称已被占用，请重新填写。',
            'description.required' => '标签描述不能为空。',
            'description.between'  => '标签描述必须介于 1 - 50 个字符之间。',
            'btn_class.required'   => '标签样式不能为空。',
            'btn_class.in'         => '标签样式不在指定样式中。',
            'order.integer'        => '排序编号必须为数字。',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

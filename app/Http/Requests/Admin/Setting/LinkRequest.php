<?php

namespace App\Http\Requests\Admin\Setting;

use App\Http\Requests\Request;

class LinkRequest extends Request
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
                'title' => 'required|between:1,25',
                'link'  => 'required|between:1,50|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            ],
            'update' => [
                'title' => 'required|between:1,25',
                'link'  => 'nullable|between:1,50|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            ],
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'title.required' => '资源名称不能为空。',
            'title.between'  => '资源名称必须介于 1 - 25 个字符之间。',
            'link.required'  => '资源链接地址不能为空。',
            'link.between'   => '资源链接地址必须介于 1 - 50 个字符之间。',
            'link.regex'     => '资源链接地址格式错误，请输入完整网址，需加上 http:// 或者 https://',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

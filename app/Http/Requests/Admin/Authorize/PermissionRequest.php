<?php

namespace App\Http\Requests\Admin\Authorize;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class PermissionRequest extends Request
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
            'update' => [
                'name'         => [
                    'required',
                    'between:3,25',
                    'regex:/^[A-Za-z\-\_]+$/',
                    Rule::unique('permissions')->ignore($this->input('id')),
                ],
                'cn_name'      => 'required|between:3,25',
            ],
            'store' => [
                'name' => 'required|between:3,25|regex:/^[A-Za-z\-\_]+$/|unique:permissions',
                'cn_name' => 'required|between:3,25',
            ],
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'name.unique'          => '权限标识已被占用，请重新填写。',
            'name.regex'           => '权限标识只支持英文、横杠和下划线。',
            'name.between'         => '权限标识必须介于 3 - 25 个字符之间。',
            'name.required'        => '权限标识不能为空。',
            'cn_name.required'     => '权限中文名称不能为空。',
            'cn_name.between'      => '权限中文名称必须介于 3 - 25 个字符之间。',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

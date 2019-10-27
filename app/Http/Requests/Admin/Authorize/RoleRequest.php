<?php

namespace App\Http\Requests\Admin\Authorize;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class RoleRequest extends Request
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
                    Rule::unique('roles')->ignore($this->input('id')),
                ],
                'cn_name'      => 'required|between:3,25',
                'permissions'  => 'required',
            ],
            'store' => [
                'name' => 'required|between:3,25|regex:/^[A-Za-z\-\_]+$/|unique:roles',
                'cn_name' => 'required|between:3,25',
                'permissions'  => 'required',
            ],
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'name.unique'          => '角色标识已被占用，请重新填写。',
            'name.regex'           => '角色标识只支持英文、横杠和下划线。',
            'name.between'         => '角色标识必须介于 3 - 25 个字符之间。',
            'name.required'        => '角色标识不能为空。',
            'cn_name.required'     => '角色中文名称不能为空。',
            'cn_name.between'      => '角色中文名称必须介于 3 - 25 个字符之间。',
            'permissions.required' => '权限不能为空。',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

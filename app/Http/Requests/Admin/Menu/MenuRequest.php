<?php

namespace App\Http\Requests\Admin\Menu;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class MenuRequest extends Request
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
                'pid'         => 'integer|min:0',
                'name'        => 'required|between:1,25|unique:menus',
                'link'        => 'nullable|between:1,25|regex:/^[a-z\.]+$/',
                'auth'        => [
                    'nullable',
                    'between:1,25',
                    'regex:/^[a-z\-]+$/',
                    function ($attribute, $value, $fail) {
                        $permissions = \DB::table('permissions')->pluck('name')->all();
                        if (! in_array($value, $permissions)) {
                            $fail('权限 「' . $value . ' 」不存在！');
                        }
                    },
                ],
                'icon'        => 'max:25',
                'description' => 'max:10',
                'sort'        => 'nullable|integer',
            ],
            'update' => [
                'pid'         => 'integer|min:0',
                'name'        => [
                    'required',
                    'between:1,25',
                    Rule::unique('menus')->ignore($this->input('id')),
                ],
                'link'        => 'nullable|between:1,25|regex:/^[a-z\.]+$/',
                'auth'        => [
                    'nullable',
                    'between:1,25',
                    'regex:/^[a-z\-]+$/',
                    function ($attribute, $value, $fail) {
                        $permissions = \DB::table('permissions')->pluck('name')->all();
                        if (! in_array($value, $permissions)) {
                            $fail('权限 「' . $value . ' 」不存在！');
                        }
                    },
                ],
                'icon'        => 'max:25',
                'description' => 'max:10',
                'sort'        => 'nullable|integer',
            ]
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'pid.integer'     => '父级 id 必须为数字类型。',
            'pid.min'         => '父级 id 最小为 0。',
            'name.required'   => '菜单名称不能为空。',
            'name.between'    => '菜单名称必须介于 1 - 25 个字符之间。',
            'name.unique'     => '菜单名称已被占用，请重新填写。',
            'link.between'    => '菜单路由必须介于 1 - 25 个字符之间。',
            'link.regex'      => '菜单路由只支持小写英文和点 「.」 号，如：menus.index',
            'auth.between'    => '所受权限影响必须介于 1 - 25 个字符之间。',
            'auth.regex'      => '所受权限影响只支持小写英文和横杠，如：create-menu',
            'icon.max'        => '图标最多为 25 个字符。',
            'description.max' => '一级菜单描述最多为 10 个字符。',
            'sort.integer'    => '排序编号必须为数字',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

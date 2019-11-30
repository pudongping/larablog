<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class UserRequest extends Request
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
                'name'         => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . \Auth::id(),
                'email'        => 'required|email',
                'introduction' => 'max:80',
                'avatar'       => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
            ],
            'store' => [
                'name'         => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users',
                'email'        => 'required|email',
                'password'     => 'required|string|min:8|confirmed',
            ],
            'adminUpdate' => [
                'name'         => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users',
                'email'        => 'required|email',
                'password'     => 'nullable|string|min:8|confirmed',
            ],
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'name.unique'        => '用户名已被占用，请重新填写。',
            'name.regex'         => '用户名只支持英文、数字、横杠和下划线。',
            'name.between'       => '用户名必须介于 3 - 25 个字符之间。',
            'name.required'      => '用户名不能为空。',
            'email.required'     => '邮箱不能为空。',
            'introduction.max'   => '个人简介不能多于 80 个字符。',
            'avatar.mimes'       => '头像必须是 jpeg, bmp, png, gif 格式的图片。',
            'avatar.dimensions'  => '图片的清晰度不够，宽和高需要 208px 以上。',
            'password.required'  => '密码不能为空。',
            'password.string'    => '密码必须为字符串。',
            'password.min'       => '密码必须为 8 个字符以上。',
            'password.confirmed' => '重复密码不一致。',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

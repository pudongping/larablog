<?php

namespace App\Http\Requests\Admin\Setting;

use App\Http\Requests\Request;

class SiteRequest extends Request
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
                'site_name' => 'required|between:1,25',
                'founder_nickname' => 'required|between:1,25',
                'founder_website' => 'nullable|between:1,25|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'contact_email'        => 'nullable|email',
                'seo_description'        => 'max:250',
                'seo_keyword'        => 'max:250',
            ]
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'site_name.between'      => '站点名称必须介于 1 - 25 个字符之间。',
            'site_name.required'     => '站点名称不能为空。',
            'founder_nickname.required'     => '站长昵称不能为空。',
            'founder_nickname.between'     => '站点昵称必须介于 1 - 25 个字符之间。',
            'founder_website.between'     => '网站地址必须介于 1 - 25 个字符之间。',
            'founder_website.regex'     => '网站地址格式错误，请输入完整网址，需加上 http:// 或者 https://',
            'contact_email.email'    => '联系人邮箱格式错误。',
            'seo_description.between'    => 'SEO - 描述信息最多可填写 255 个字符。',
            'seo_keyword.between'    => 'SEO - 关键词最多可填写 255 个字符。',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

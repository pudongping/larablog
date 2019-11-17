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
                'name' => 'required|between:1,25',
                'contact_email'        => 'required|email',
                'seo_description'        => 'required|between:3,250',
                'seo_keyword'        => 'required|between:3,250',
            ]
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'name.between'      => '站点名称必须介于 1 - 25 个字符之间。',
            'name.required'     => '站点名称不能为空。',
            'contact_email.required'    => '联系人邮箱不能为空。',
            'contact_email.email'    => '联系人邮箱格式错误。',
            'seo_description.required'    => 'SEO - 描述信息不能为空。',
            'seo_description.between'    => 'SEO - 描述信息必须介于 3 - 25 个字符之间。',
            'seo_keyword.required'    => 'SEO - 关键词不能为空。',
            'seo_keyword.between'    => 'SEO - 关键词必须介于 3 - 25 个字符之间。',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

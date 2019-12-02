<?php

namespace App\Http\Requests\Portal\Article;

use App\Http\Requests\Request;

class ReplyRequest extends Request
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
                'article_id' => 'required|numeric|min:0',
                'content'    => 'required|min:3',
            ],
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'article_id.numeric' => '请回复有效的文章',
            'article_id.min'     => '请回复有效的文章',
            'content.min'        => '回复内容至少三个字符',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }


}

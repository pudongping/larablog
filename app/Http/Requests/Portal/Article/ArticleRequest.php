<?php

namespace App\Http\Requests\Portal\Article;

use App\Http\Requests\Request;

class ArticleRequest extends Request
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
                'title'       => 'required|min:2',
                'category_id' => 'required|numeric',
            ],
            'update' => [
                'id'       => 'required|min:1',
                'title'       => 'required|min:2',
                'category_id' => 'required|numeric',
            ],
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'title.min' => '标题必须至少两个字符',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

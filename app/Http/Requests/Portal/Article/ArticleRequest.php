<?php

namespace App\Http\Requests\Portal\Article;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

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
                'title'        => 'required|min:2',
                'category_id'  => 'required|numeric',
                'tag_id'       => [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) {
                        $tagIds = \DB::table('tags')->pluck('id')->all();
                        $value = array_map(function ($reqItem) {
                            return intval($reqItem);
                        }, $value);
                        if (count($value) > 5) $fail('标签最多添加 5 个！');
                        $onlyReqTagIds = array_diff($value, $tagIds);
                        if (!empty($onlyReqTagIds)) {
                            $fail($attribute . ' 标签数据不合法');
                        }
                    },
                ],
                'markdownbody' => Rule::requiredIf(function () {
                    return boolval($this->input('is_markdown'));
                }),
                'htmlbody'     => Rule::requiredIf(function () {
                    return !boolval($this->input('is_markdown'));
                }),
            ],
            'update' => [
                'id'           => 'required|min:1',
                'title'        => 'required|min:2',
                'category_id'  => 'required|numeric',
                'tag_id'       => [
                    'required',
                    'array',
                    function ($attribute, $value, $fail) {
                        $tagIds = \DB::table('tags')->pluck('id')->all();
                        $value = array_map(function ($reqItem) {
                            return intval($reqItem);
                        }, $value);
                        if (count($value) > 5) $fail('标签最多添加 5 个！');
                        $onlyReqTagIds = array_diff($value, $tagIds);
                        if (!empty($onlyReqTagIds)) {
                            $fail($attribute . ' 标签数据不合法');
                        }
                    },
                ],
                'markdownbody'  => Rule::requiredIf(function () {
                    return boolval($this->input('is_markdown'));
                }),
                'htmlbody'      => Rule::requiredIf(function () {
                    return !boolval($this->input('is_markdown'));
                }),
            ],
        ];

        return $this->useRule($rules);
    }

    public function messages()
    {
        $messages = [
            'title.required'        => '标题不能为空',
            'title.min'             => '标题必须至少两个字符',
            'category_id.required'  => '标题必须至少两个字符',
            'category_id.numeric'   => '分类必须为数字',
            'tag_id.required'       => '标签不能为空',
            'tag_id.array'          => '标签必须为数组',
            'id.required'           => '编辑文章时，文章 id 不能为空',
            'id.min'                => '编辑文章时，文章 id 不能小于 1',
            'markdownbody.required' => '文章内容不能为空',
            'htmlbody.required'     => '文章内容不能为空',
        ];

        $messages = array_merge(parent::messages(), $messages);

        return $messages;
    }

}

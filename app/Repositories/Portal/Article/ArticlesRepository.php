<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/20
 * Time: 22:37
 */

namespace App\Repositories\Portal\Article;

use App\Handlers\ImageUploadHandler;
use App\Repositories\BaseRepository;
use App\Models\Portal\Article\Article;

class ArticlesRepository extends BaseRepository
{

    protected $model;
    protected $imageUploadHandler;

    public function __construct(
        Article $article,
        ImageUploadHandler $imageUploadHandler
    ) {
        $this->model = $article;
        $this->imageUploadHandler = $imageUploadHandler;
    }

    /**
     * 文章列表
     *
     * @param $request  请求实例
     * @return mixed
     */
    public function index($request)
    {
        // 使用了「Article」模型中的排序规则动态作用域
        $model = Article::withOrder($request->order);
        return $this->usePage($model);
    }

    /**
     * 新建文章-保存数据
     *
     * @param $request  请求实例
     * @return object  已保存的文章对象
     */
    public function storage($request)
    {
        $input = $request->only(['title', 'category_id']);
        $input['body'] = $this->getBody($request);
        $input['user_id'] = \Auth::id();

        return $this->store($input);
    }

    /**
     * 「Simditor」富文本编辑器上传图片
     *
     * @link  https://simditor.tower.im//docs/doc-config.html
     * @param $request  请求实例
     * @return array  按照 simditor 文档要求返回的数据格式
     */
    public function uploadImage($request)
    {
        $data = [
            'success'   => false,
            'msg'       => '上传失败！',
            'file_path' => ''
        ];

        // 判断是否有上传文件
        if ($file = $request->image) {
            $result = $this->imageUploadHandler->save($file, 'articles', \Auth::id(), 'image', 1024);
            if ($result) {
                $data['success'] = true;
                $data['msg'] = '上传成功！';
                $data['file_path'] = $result['path']; // 带 url 的绝对路径
            }
        }

        return $data;
    }

    /**
     * 「simplemde」 markdown 编辑器拖拽上传图片
     *
     * @param $request  请求实例
     * @return array  参照 node_modules/inline-attachment/demo/upload_attachment.php 返回的格式
     */
    public function uploadMarkdownImage($request)
    {
        $data = [
            'filename' => '',
            'error'    => '上传失败！'
        ];

        if ($file = $request->file) {
            $result = $this->imageUploadHandler->save($file, 'articles', \Auth::id(), 'file', 1024);
            if ($result) {
                $data['error'] = '上传成功！';
                $data['filename'] = $result['path']; // 必须为带 url 的绝对路径
            }
        }

        return $data;
    }

    /**
     * 编辑文章-数据处理
     *
     * @param $request  请求实例
     * @return mixed  当前更新文章实例
     */
    public function modify($request)
    {
        $input = $request->only('title', 'category_id');
        $input['body'] = $this->getBody($request);
        $data = $this->update($request->id, $input);
        return $data;
    }

    /**
     *  获取文章内容
     *
     * @param $request  当前请求实例
     * @return string  html 格式的文章内容
     * @throws \Exception
     */
    private function getBody($request)
    {
        // 判断当前提交的文章是否是 markdown 文本内容
        if ($request->is_markdown) {
            $html = markdown_2_html($request->markdownbody);
        } else {
            $html = $request->htmlbody;
        }

        if (empty(trim($html))) {
            throw new \Exception('文章内容不能为空');
        }

        return $html;
    }



}

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
        $input = $request->only(['title', 'category_id', 'body']);
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



}

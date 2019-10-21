<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/20
 * Time: 22:37
 */

namespace App\Repositories\Portal\Article;

use App\Repositories\BaseRepository;
use App\Models\Portal\Article\Article;

class ArticlesRepository extends BaseRepository
{

    protected $model;

    public function __construct(
        Article $article
    ) {
        $this->model = $article;
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

}
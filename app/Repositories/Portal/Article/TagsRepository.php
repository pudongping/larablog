<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/11/23
 * Time: 18:42
 */

namespace App\Repositories\Portal\Article;

use App\Repositories\BaseRepository;
use App\Models\Portal\Article\Tag;

class TagsRepository extends BaseRepository
{

    protected $model;

    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    /**
     * 获取所有的资源推荐
     *
     * @return mixed
     */
    public function getAllTagsInCache()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出 tags 表中所有的数据，返回的同时做了缓存。
        return \Cache::remember($this->model->cacheKey, $this->model->getCacheExpireInSeconds(), function () {
            return $this->model->orderBy('order', 'desc')->orderBy('id', 'asc')->get();
        });
    }

}

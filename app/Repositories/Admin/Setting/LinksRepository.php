<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-28
 * Time: 16:42
 */

namespace App\Repositories\Admin\Setting;

use App\Repositories\BaseRepository;
use App\Models\Admin\Setting\Link;

class LinksRepository extends BaseRepository
{

    protected $model;

    public function __construct(Link $link)
    {
        $this->model = $link;
    }

    /**
     * 获取所有的资源推荐
     *
     * @return mixed
     */
    public function getAllLinksInCache()
    {
        // 尝试从缓存中取出 cache_key 对应的数据。如果能取到，便直接返回数据。
        // 否则运行匿名函数中的代码来取出 links 表中所有的数据，返回的同时做了缓存。
        return \Cache::remember($this->model->cacheKey, $this->model->getCacheExpireInSeconds(), function () {
            return $this->all();
        });
    }

}

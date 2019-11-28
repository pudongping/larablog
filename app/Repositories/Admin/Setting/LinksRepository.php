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

    /**
     * 带搜索功能的资源推荐列表
     *
     * @param $request
     * @return mixed
     */
    public function index($request)
    {

        $search = $request->search;

        $model = $this->model->where(function ($query) use ($search) {
            if (! empty($search)) {
                $query->orWhere('title', 'like', '%' . $search . '%');
                $query->orWhere('link', 'like', '%' . $search . '%');
            }
        });

        $links = $this->usePage($model);

        return $links;
    }

    /**
     * 添加资源推荐-数据处理
     *
     * @param $request  当前请求实例
     * @return mixed
     */
    public function storage($request)
    {
        $input = $request->only(['title', 'link']);
        $link = $this->store($input);
        return $link;
    }

    /**
     * 编辑资源推荐-数据处理
     *
     * @param $request  当前请求实例
     * @return mixed
     */
    public function modify($request)
    {
        $input = $request->only(['title', 'link']);
        $link = $this->update($request->id, $input);
        return $link;
    }

}

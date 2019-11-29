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
use App\Support\TempValue;

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
            TempValue::$nopage = true;
            return $this->usePage($this->model, ['order', 'id'], ['desc', 'asc']);
        });
    }

    /**
     * 根据标签查询文章
     *
     * @param $tag  object  标签实例
     * @return mixed
     */
    public function show($tag)
    {
        return $tag->articles()->withOrder(request()->order)->paginate(\ConstCustom::PAGE_NUM);
    }

    /**
     * 标签列表
     *
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $search = $request->search;

        $model = $this->model->where(function ($query) use ($search) {
            if (! empty($search)) {
                $query->orWhere('name', 'like', '%' . $search . '%');
                $query->orWhere('description', 'like', '%' . $search . '%');
            }
        });

        $tags = $this->usePage($model, ['order', 'id'], ['desc']);

        return $tags;
    }

    /**
     * 新增标签-数据处理
     *
     * @param $request
     * @return mixed
     */
    public function storage($request)
    {
        $input = $request->only(['name', 'description', 'btn_class', 'order']);
        $input['order'] = $request->order ?? 0;
        $tag = $this->store($input);
        return $tag;
    }

    /**
     * 编辑标签-数据处理
     *
     * @param $request
     * @return mixed
     */
    public function modify($request)
    {
        $input = $request->only(['name', 'description', 'btn_class', 'order']);
        $input['order'] = $request->order ?? 0;
        $tag = $this->update($request->id, $input);
        return $tag;
    }

}

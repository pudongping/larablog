<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/21
 * Time: 0:29
 */

namespace App\Repositories\Portal\Article;

use App\Models\Portal\Article\Category;
use App\Repositories\BaseRepository;

class CategoriesRepository extends BaseRepository
{

    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * 获取所有的分类
     *
     * @return mixed  键名为分类 id，键值为分类名称的二维数组
     */
    public function getAllCategories()
    {
        return $this->model->orderBy('id', 'asc')->pluck('name', 'id')->all();
    }

    /**
     * 分类列表
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
            }
        });

        $categories = $this->usePage($model);

        return $categories;
    }

    /**
     * 新建分类-数据处理
     *
     * @param $request
     * @return mixed
     */
    public function storage($request)
    {
        $input = $request->only(['name', 'description']);
        $category = $this->store($input);
        return $category;
    }

    /**
     * 编辑分类-数据处理
     *
     * @param $request
     * @return mixed
     */
    public function modify($request)
    {
        $input = $request->only(['name', 'description']);
        $category = $this->update($request->id, $input);
        return $category;
    }

}

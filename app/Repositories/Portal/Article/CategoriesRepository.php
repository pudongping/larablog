<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/21
 * Time: 0:29
 */

namespace App\Repositories\Portal\Article;

use App\Models\Portal\Article\Category;

class CategoriesRepository
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

}
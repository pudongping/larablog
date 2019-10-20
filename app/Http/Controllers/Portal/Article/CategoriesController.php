<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/20
 * Time: 23:54
 */

namespace App\Http\Controllers\Portal\Article;

use App\Http\Controllers\Controller;
use App\Models\Portal\Article\Category;
use App\Models\Portal\Article\Article;

class CategoriesController extends Controller
{

    /**
     * 根据分类查看文章
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Category $category)
    {
        // 读取分类 id 相关的文章
        $articles = Article::where('category_id', $category->id)->paginate(\ConstCustom::PAGE_NUM);

        return view('portal.article.index', compact('articles', 'category'));
    }

}
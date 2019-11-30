<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Portal\Article\ArticlesRepository;
use App\Models\Portal\Article\Article;
use App\Models\Portal\Article\Category;
use App\Repositories\Portal\Article\TagsRepository;

class ArticlesController extends Controller
{

    protected $articlesRepository;
    protected $tagsRepository;

    public function __construct(
        ArticlesRepository $articlesRepository,
        TagsRepository $tagsRepository
    ) {
        $this->articlesRepository = $articlesRepository;
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * 后台管理-文章列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminIndex(Request $request)
    {
        $data = $this->articlesRepository->adminIndex($request);
        return view('admin.article.index', $data);
    }

    /**
     * 后台管理-编辑文章
     *
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminEdit(Article $article)
    {
        $categories = Category::all();
        $tags = $this->tagsRepository->getAllTagsInCache();
        session(['adminEdit' => true]);  // 记录当前文章编辑页面是从后台管理返回出去的
        return view('portal.article.create_and_edit', compact('article', 'categories', 'tags'));
    }

    /**
     * 后台管理-删除文章
     *
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function adminDestroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.admin_index')->with('success', '文章 「' . $article->title . ' 」删除成功！');
    }

}

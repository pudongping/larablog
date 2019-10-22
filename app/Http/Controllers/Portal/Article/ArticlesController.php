<?php

namespace App\Http\Controllers\Portal\Article;

use App\Http\Controllers\Controller;
use App\Models\Portal\Article\Article;
use App\Models\Portal\Article\Category;
use Illuminate\Http\Request;
use App\Repositories\Portal\Article\ArticlesRepository;
use App\Repositories\Portal\Article\CategoriesRepository;
use App\Http\Requests\Portal\Article\ArticleRequest;

class ArticlesController extends Controller
{

    protected $articlesRepository;
    protected $categoriesRepository;

    public function __construct(
        ArticlesRepository $articlesRepository,
        CategoriesRepository $categoriesRepository
    ) {
        $this->articlesRepository = $articlesRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * 文章列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $articles = $this->articlesRepository->index($request);
        $allCategories = $this->categoriesRepository->getAllCategories();
        return view('portal.article.index', compact('articles', 'allCategories'));
    }

    /**
     * 新建-编辑 文章显示页面
     *
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Article $article)
    {
        $categories = Category::all();
        return view('portal.article.create_and_edit', compact('article', 'categories'));
    }

    /**
     * 新建文章-数据处理
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request)
    {
        $article = $this->articlesRepository->storage($request);
        return redirect()->route('articles.show', $article->id)->with('success', '文章创建成功！');
    }

    /**
     * 文章详情
     *
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Article $article)
    {
        return view('portal.article.show', compact('article'));
    }

    /**
     * 「Simditor」富文本编辑器上传图片
     *
     * @param Request $request  请求实例
     * @return array
     */
    public function uploadImage(Request $request)
    {
        $data = $this->articlesRepository->uploadImage($request);
        return $data;
    }

}

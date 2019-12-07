<?php

namespace App\Http\Controllers\Portal\Article;

use App\Http\Controllers\Controller;
use App\Models\Portal\Article\Article;
use App\Models\Portal\Article\Category;
use Illuminate\Http\Request;
use App\Repositories\Portal\Article\ArticlesRepository;
use App\Repositories\Portal\Article\CategoriesRepository;
use App\Http\Requests\Portal\Article\ArticleRequest;
use App\Repositories\Portal\Article\TagsRepository;
use App\Handlers\SiteMapHandler;

class ArticlesController extends Controller
{

    protected $articlesRepository;
    protected $categoriesRepository;
    protected $tagsRepository;
    protected $siteMapHandler;

    public function __construct(
        ArticlesRepository $articlesRepository,
        CategoriesRepository $categoriesRepository,
        TagsRepository $tagsRepository,
        SiteMapHandler $siteMapHandler
    ) {
        $this->articlesRepository = $articlesRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->tagsRepository = $tagsRepository;
        $this->siteMapHandler = $siteMapHandler;
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
        return view('portal.article.index', compact('articles'));
    }

    /**
     * 新建文章显示页面
     *
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Article $article)
    {
        $categories = Category::all();
        $tags = $this->tagsRepository->getAllTagsInCache();
        return view('portal.article.create_and_edit', compact('article', 'categories', 'tags'));
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
        return redirect()->to($article->link())->with('success', '文章 「' . $article->title . ' 」创建成功！');
    }

    /**
     * 文章详情
     *
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Article $article)
    {

        if ($request->is_markdown) {
            // 返回 markdown 文本内容
            return response(html_2_markdown($article->body), 200)->header('Content-Type', 'text/x-markdown');
        }

        // url 矫正 （强制跳转到带有 slug 的 url）
        if ((!empty($article->slug)) && ($article->slug != $request->slug)) {
            return redirect($article->link(), 301);
        }

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

    /**
     * 「simplemde」 markdown 编辑器拖拽上传图片
     *
     * @param Request $request  请求实例
     * @return array
     */
    public function uploadMarkdownImage(Request $request)
    {
        $data = $this->articlesRepository->uploadMarkdownImage($request);
        return $data;
    }

    /**
     * 编辑文章显示页面
     *
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Article $article)
    {
        // 查看编辑授权策略
        $this->authorize('updatePolicy', $article);

        $categories = Category::all();
        $tags = $this->tagsRepository->getAllTagsInCache();
        return view('portal.article.create_and_edit', compact('article', 'categories', 'tags'));
    }

    /**
     * 编辑文章-数据处理
     *
     * @param ArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleRequest $request, Article $article)
    {
        // 如果是从后台页面返回出的编辑页面，则跳过验证
        if (! session('adminEdit')) {
            // 提交修改授权策略
            $this->authorize('updatePolicy', $article);
        }
        $request->session()->forget('adminEdit');

        $article = $this->articlesRepository->modify($request);
        return redirect()->to($article->link())->with('success', '文章 「' . $article->title . ' 」更新成功！');
    }

    /**
     * 删除文章
     *
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Article $article)
    {
        // 删除文章授权策略
        $this->authorize('destroyPolicy', $article);

        $article->delete();
        return redirect()->route('articles.index')->with('success', '文章 「' . $article->title . ' 」删除成功！');
    }

    /**
     * 站点地图
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function siteMap()
    {
        $map = $this->siteMapHandler->fetchSiteMap();
        return response($map, 200)->header('Content-Type', 'text/xml');
    }

}

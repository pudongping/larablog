<?php

namespace App\Http\Controllers\Portal\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Portal\Article\ArticlesRepository;
use App\Repositories\Portal\Article\CategoriesRepository;

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

}

<?php

namespace App\Http\Controllers\Portal\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Portal\Article\ArticlesRepository;

class ArticlesController extends Controller
{

    protected $articlesRepository;

    public function __construct(
        ArticlesRepository $articlesRepository
    ) {
        $this->articlesRepository = $articlesRepository;
    }

    public function index()
    {
        $articles = $this->articlesRepository->index();
        return view('portal.article.index', compact('articles'));
    }

}

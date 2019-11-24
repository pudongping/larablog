<?php

namespace App\Http\Controllers\Portal\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Portal\Article\TagsRepository;
use App\Models\Portal\Article\Tag;


class TagsController extends Controller
{

    protected $tagsRepository;

    public function __construct(TagsRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * 根据标签查询文章
     *
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Tag $tag)
    {
        $articles = $this->tagsRepository->show($tag);
        return view('portal.article.index', compact('articles'));
    }

}

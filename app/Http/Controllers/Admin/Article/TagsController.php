<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Portal\Article\TagsRepository;
use App\Http\Requests\Admin\Article\TagRequest;
use App\Models\Portal\Article\Tag;

class TagsController extends Controller
{

    protected $tagsRepository;

    public function __construct(TagsRepository $tagsRepository)
    {
        $this->tagsRepository = $tagsRepository;
    }

    /**
     * 标签列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tags = $this->tagsRepository->index($request);
        return view('admin.tag.index', compact('tags'));
    }

    /**
     * 新增标签-渲染页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $btnClasses = Tag::$allowedBtnClass;
        return view('admin.tag.create_and_edit', compact('btnClasses'));
    }

    /**
     * 新增标签-数据处理
     *
     * @param TagRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TagRequest $request)
    {
        $tag = $this->tagsRepository->storage($request);
        return redirect()->route('tags.index')->with('success', '标签「 ' . $tag->name . ' 」创建成功！');
    }

    /**
     * 编辑标签-页面渲染
     *
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Tag $tag)
    {
        $btnClasses = Tag::$allowedBtnClass;
        return view('admin.tag.create_and_edit', compact('tag', 'btnClasses'));
    }

    /**
     * 编辑标签-数据处理
     *
     * @param TagRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TagRequest $request)
    {
        $tag = $this->tagsRepository->modify($request);
        return redirect()->route('tags.index')->with('success', '标签「 ' . $tag->name . ' 」修改成功！');
    }

    /**
     * 删除标签
     *
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('tags.index')->with('success', '标签「 ' . $tag->name . ' 」删除成功！');
    }

}

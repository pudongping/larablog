<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\Setting\LinksRepository;
use App\Http\Requests\Admin\Setting\LinkRequest;
use App\Models\Admin\Setting\Link;

class LinksController extends Controller
{

    protected $linksRepository;

    public function __construct(LinksRepository $linksRepository)
    {
        $this->linksRepository = $linksRepository;
    }

    /**
     * 资源推荐列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $links = $this->linksRepository->index($request);
        return view('admin.link.index', compact('links'));
    }

    /**
     * 添加资源推荐-渲染页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.link.create_and_edit');
    }

    /**
     * 添加资源推荐-数据处理
     *
     * @param LinkRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LinkRequest $request)
    {
        $link = $this->linksRepository->storage($request);
        return redirect()->route('links.index')->with('success', '资源「 ' . $link->title . ' 」创建成功！');
    }

    /**
     * 编辑资源推荐-渲染页面
     *
     * @param Link $link  当前资源推荐实例
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Link $link)
    {
        return view('admin.link.create_and_edit', compact('link'));
    }

    /**
     * 编辑资源推荐-数据处理
     *
     * @param LinkRequest $request  当前请求实例
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LinkRequest $request)
    {
        $link = $this->linksRepository->modify($request);
        return redirect()->route('links.index')->with('success', '资源「 ' . $link->title . ' 」修改成功！');
    }

    /**
     * 删除资源推荐
     *
     * @param Link $link  当前资源推荐实例
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Link $link)
    {
        $link->delete();
        return redirect()->route('links.index')->with('success', '资源「 ' . $link->title . ' 」删除成功！');
    }

}

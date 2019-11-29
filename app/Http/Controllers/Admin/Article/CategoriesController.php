<?php

namespace App\Http\Controllers\Admin\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Portal\Article\CategoriesRepository;
use App\Http\Requests\Admin\Article\CategoryRequest;
use App\Models\Portal\Article\Category;

class CategoriesController extends Controller
{

    protected $categoriesRepository;

    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    /**
     * 分类列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categories = $this->categoriesRepository->index($request);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * 新建分类-页面渲染
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.category.create_and_edit');
    }

    /**
     * 新建分类-数据处理
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $category = $this->categoriesRepository->storage($request);
        return redirect()->route('categories.index')->with('success', '分类「 ' . $category->name . ' 」创建成功！');
    }

    /**
     * 编辑分类-页面渲染
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('admin.category.create_and_edit', compact('category'));
    }

    /**
     * 编辑分类-数据处理
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request)
    {
        $category = $this->categoriesRepository->modify($request);
        return redirect()->route('categories.index')->with('success', '分类「 ' . $category->name . ' 」修改成功！');
    }

    /**
     * 删除分类
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', '分类「 ' . $category->name . ' 」删除成功！');
    }


}

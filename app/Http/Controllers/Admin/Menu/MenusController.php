<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\Menu\MenusRepository;
use App\Http\Requests\Admin\Menu\MenuRequest;
use App\Models\Admin\Menu\Menu;

class MenusController extends Controller
{

    protected $menusRepository;

    public function __construct(MenusRepository $menusRepository)
    {
        $this->menusRepository = $menusRepository;
    }

    /**
     * 菜单列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $this->menusRepository->getList($request);
        return view('admin.menu.index', $data);
    }

    /**
     * 创建菜单-页面渲染
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $topLevelMenus = $this->menusRepository->topLevelMenu();
        return view('admin.menu.create_and_edit', compact('topLevelMenus'));
    }

    /**
     * 创建菜单-数据处理
     *
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MenuRequest $request)
    {
        $menu = $this->menusRepository->storage($request);
        return redirect()->route('menus.index')->with('success', '菜单「 ' . $menu->name . ' 」创建成功！');
    }

    /**
     * 编辑菜单-页面渲染
     *
     * @param Menu $menu  当前菜单实例
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Menu $menu)
    {
        $topLevelMenus = $this->menusRepository->topLevelMenu();
        // 不能将自己作为父级菜单
        unset($topLevelMenus[$menu->id]);
        return view('admin.menu.create_and_edit', compact('topLevelMenus', 'menu'));
    }

    /**
     * 编辑菜单-数据处理
     *
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MenuRequest $request)
    {
        $menu = $this->menusRepository->modify($request);
        return redirect()->route('menus.index')->with('success', '菜单「 ' . $menu->name . ' 」修改成功！');
    }

    /**
     * 删除菜单
     *
     * @param Menu $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Menu $menu)
    {
        $data = $this->menusRepository->destroy($menu);
        return redirect()->route('menus.index')->with($data);
    }


}

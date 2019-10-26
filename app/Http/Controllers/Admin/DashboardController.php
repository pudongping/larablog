<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-25
 * Time: 17:25
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\Menu\MenusRepository;

class DashboardController extends Controller
{

    protected $menusRepository;

    public function __construct(MenusRepository $menusRepository)
    {
        $this->menusRepository = $menusRepository;
    }

    /**
     * 后台管理仪表盘
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function root()
    {
        $menusTree = $this->menusRepository->menusTree();
        return view('admin.layouts.sapp', compact('menusTree'));
    }


}

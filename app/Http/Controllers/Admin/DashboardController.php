<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-25
 * Time: 17:25
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\DashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    protected $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    /**
     * 后台管理仪表盘
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function root(Request $request)
    {
        $data = $this->dashboardRepository->root($request);
        return view('admin.dashboard.index', $data);
    }



}

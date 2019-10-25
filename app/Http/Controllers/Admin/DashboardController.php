<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019-10-25
 * Time: 17:25
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    /**
     * 后台管理仪表盘
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function root()
    {
        return view('admin.layouts.sapp');
    }


}

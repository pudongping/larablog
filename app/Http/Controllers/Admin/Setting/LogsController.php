<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Support\ConstCustom;

class LogsController extends Controller
{

    /**
     * 用户操作日志记录
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = \Auth::user();
        $logs = \Auth::user()->logs()->orderBy('created_at', 'desc')->paginate(ConstCustom::PAGE_NUM);
        return view('auth.users.log', compact('user', 'logs'));
    }

}

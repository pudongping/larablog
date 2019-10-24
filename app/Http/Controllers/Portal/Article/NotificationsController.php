<?php

namespace App\Http\Controllers\Portal\Article;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        // 获取登录用户的所有通知
        // notifications 方法来自 app(Illuminate\Notifications\HasDatabaseNotifications)->notifications()
        $notifications = \Auth::user()->notifications()->paginate(\ConstCustom::PAGE_NUM);

        // 标记为已读，未读数量清零
        \Auth::user()->markAsRead();

        return view('portal.notifications.index', compact('notifications'));
    }
}

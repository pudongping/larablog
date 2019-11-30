<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/11/30
 * Time: 2:18
 */

namespace App\Observers\Auth;

use App\Models\Auth\User;


class UserObserver
{
    public function deleted(User $user)
    {
        // 当用户被删除时，和当前用户相关的一切均要被删除
        // 避免再次触发 Eloquent 事件，以免造成联动逻辑冲突。所以这里我们使用了 DB 类进行操作
        // deleted 方法只对 「Eloquent 模型」 有效
        \DB::table('fans')->where('user_id', $user->id)->delete();
        \DB::table('logs')->where('user_id', $user->id)->delete();

        // articles、replies、model_has_roles、model_has_permissions 均有外键约束，因此不用处理

    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Auth\User;
use App\Models\Admin\Authorize\Role;

class MaintainerMiddleware
{
    /**
     * 判断当前用户是否有 「管理员」 的所有权限
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // 当前用户表中所有用户数量
        $users = User::all()->count();
        // 如果用户表中只有一个用户，那么则跳过权限判断
        if (1 <> $users) {

            // 「管理员」 的 id
            $roleId = Role::findByName('Maintainer')->id;
            $permissions = \DB::table('role_has_permissions')
                ->where('role_id', $roleId)
                ->pluck('permission_id')
                ->toArray();

            // 当前用户所有的权限 id
            $crtUserPmiIds = \Auth::user()->getAllPermissions()->pluck('id')->toArray();
            // 比较当前用户是否含有所有 「管理员」 的权限 id，如果含有所有，则证明当前用户具有 「管理员权限」
            // 可能用户所属角色有操作权限，但是可能用户并没有设置相应的权限，比如，当前用户为 「站长」 角色，理当拥有所有权限
            // 但是此时用户只拥有一个 「站长」 角色，并没有拥有 「管理员」 角色，因此索性直接通过 「权限」来判断，因为角色依赖于权限
            $result = array_diff($permissions, $crtUserPmiIds);

            // 判断当前登录用户是否有 「管理员权限」 权限
            if ($result) abort(401);
        }

        return $next($request);
    }
}

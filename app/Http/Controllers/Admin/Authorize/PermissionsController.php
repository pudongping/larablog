<?php

namespace App\Http\Controllers\Admin\Authorize;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Admin\Authorize\PermissionsRepository;
use App\Models\Admin\Authorize\Permission;
use App\Http\Requests\Admin\Authorize\PermissionRequest;
use App\Models\Admin\Authorize\Role;

class PermissionsController extends Controller
{

    protected $permissionsRepository;

    public function __construct(PermissionsRepository $permissionsRepository)
    {
        $this->permissionsRepository = $permissionsRepository;
    }

    /**
     * 权限列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $permissions = $this->permissionsRepository->permissionTree();
        return view('admin.permission.index', compact('permissions'));
    }

    /**
     * 编辑权限显示
     *
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        $permissions = $this->permissionsRepository->permissionTree();
        // 父级不能自己选择自己
        unset($permissions[$permission->id]);
        return view('admin.permission.edit', compact('permission', 'permissions'));
    }

    /**
     * 编辑权限数据处理
     *
     * @param PermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PermissionRequest $request)
    {
        $permission = $this->permissionsRepository->modify($request);
        return redirect()->route('permissions.index')->with('success', $permission->name . ' 修改成功！');
    }

    /**
     * 删除权限
     *
     * @param Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Permission $permission)
    {
        $data = $this->permissionsRepository->destroy($permission);
        return redirect()->route('permissions.index')->with($data);
    }

    /**
     * 新建权限视图显示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::get();
        $permissions = $this->permissionsRepository->permissionTree();
        return view('admin.permission.create', compact('roles', 'permissions'));
    }

    /**
     * 新建权限数据保存
     *
     * @param PermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PermissionRequest $request)
    {
        $permission = $this->permissionsRepository->storage($request);
        return redirect()->route('permissions.index')->with('success', '权限 「' . $permission->name . '」 创建成功！');
    }



}

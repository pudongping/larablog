<?php

namespace App\Http\Controllers\Admin\Authorize;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Authorize\Role;
use App\Repositories\Admin\Authorize\PermissionsRepository;
use App\Http\Requests\Admin\Authorize\RoleRequest;
use App\Repositories\Admin\Authorize\RolesRepository;

class RolesController extends Controller
{

    protected $permissionsRepository;
    protected $rolesRepository;

    public function __construct(
        PermissionsRepository $permissionsRepository,
        RolesRepository $rolesRepository
    ) {
        $this->permissionsRepository = $permissionsRepository;
        $this->rolesRepository = $rolesRepository;
    }

    /**
     * 角色列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * 添加角色视图显示
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = $this->permissionsRepository->permissionTree();
        return view('admin.role.create', compact('permissions'));
    }

    /**
     * 新建角色数据保存
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        $role = $this->rolesRepository->storage($request);
        return redirect()->route('roles.index')->with('success', '角色 「' . $role->name . '」 创建成功！');
    }

    /**
     * 修改角色视图显示
     *
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $permissions = $this->permissionsRepository->permissionTree();
        $checkedPermissions = $role->permissions()->pluck('name', 'id')->toArray();
        return view('admin.role.edit', compact('role', 'permissions', 'checkedPermissions'));
    }

    /**
     * 修改角色数据提交处理
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request)
    {
        $role = $this->rolesRepository->modify($request);
        return redirect()->route('roles.index')->with('success', '角色「 ' . $role->name . ' 」修改成功！');
    }

    /**
     * 删除角色
     *
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $data = $this->rolesRepository->destroy($role);
        return redirect()->route('roles.index')->with($data);
    }

}

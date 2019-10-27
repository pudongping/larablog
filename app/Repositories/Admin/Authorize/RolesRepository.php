<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/28
 * Time: 0:54
 */

namespace App\Repositories\Admin\Authorize;

use App\Repositories\BaseRepository;
use App\Models\Admin\Authorize\Role;
use App\Models\Admin\Authorize\Permission;

class RolesRepository extends BaseRepository
{

    protected $model;

    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * 修改角色
     *
     * @param $request
     * @return mixed
     */
    public function modify($request)
    {
        $input = $request->only('name', 'cn_name');
        $role = $this->update($request->id, $input);

        $pAll = Permission::all();
        foreach ($pAll as $p) {
            // 删除与角色关联的所有权限
            $role->revokePermissionTo($p);
        }

        // 当前选中的所有权限 id
        $permissionsId = $request->permissions;
        $permissions = Permission::whereIn('id', $permissionsId)->get();

        // 将多个权限同步赋予到一个角色
        $role->syncPermissions($permissions);

        return $role;
    }

    /**
     * 删除角色
     *
     * @param $role
     * @return array
     */
    public function destroy($role)
    {
        if (in_array($role->name, Role::DEFAULT_ROLES)) {
            // 站长角色不允许删除
            return ['danger' => '「 站长 」角色不允许删除！'];
        }
        $role->delete();
        return ['success' => '角色 「' . $role->name . ' 」 删除成功！'];
    }

    /**
     * 添加新角色数据处理
     *
     * @param $request
     * @return mixed
     */
    public function storage($request)
    {
        $input = $request->only('name', 'cn_name');
        $role = $this->store($input);

        // 当前选中的所有权限 id
        $permissionsId = $request->permissions;
        $permissions = Permission::whereIn('id', $permissionsId)->get();

        // 将多个权限同步赋予到一个角色
        $role->syncPermissions($permissions);

        return $role;

    }

}
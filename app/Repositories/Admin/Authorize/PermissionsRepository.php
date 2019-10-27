<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/27
 * Time: 1:06
 */

namespace App\Repositories\Admin\Authorize;

use App\Repositories\BaseRepository;
use App\Models\Admin\Authorize\Permission;
use App\Models\Admin\Authorize\Role;

class PermissionsRepository extends BaseRepository
{

    protected $model;

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /**
     * 权限列表
     *
     * @return array
     */
    public function permissionTree()
    {
        $permissions = Permission::all()->toArray();
        $data = $this->tree($permissions);
        return $data;
    }

    /**
     * 根据父子关系重新排序
     *
     * @param $data  具有父子关系的二维数组
     * @param int $root  获取指定层级标识
     * @param array $result  用于保存数据的数组
     * @return array
     */
    private function tree($data, $root = 0, &$result = []) : array
    {
        foreach ($data as $item) {
            // 排除掉非直接子集
            if ($item['pid'] != $root) {
                continue;
            }
            $result[$item['id']] = $item;
            $this->tree($data, $item['id'], $result);
        }
        return $result;
    }

    /**
     * 更新权限
     *
     * @param $request
     * @return mixed
     */
    public function modify($request)
    {
        $input = $request->only('name', 'cn_name', 'pid');
        // 如果没有选择父级 id，则直接排除掉
        if (is_null($input['pid'])) unset($input['pid']);
        $data = $this->update($request->id, $input);
        return $data;
    }

    /**
     * 删除权限
     *
     * @param $permission  需要删除的权限实例
     * @return array
     */
    public function destroy($permission)
    {
        if (in_array($permission->name, Permission::DEFAULT_PERMISSIONS)) {
            // 默认权限不允许删除
            return ['danger' => '默认权限不允许删除！'];
        }
        $permission->delete();
        return ['success' => '权限 「' . $permission->name . '」 删除成功！'];
    }

    /**
     * 保存权限
     *
     * @param $request
     * @return mixed
     */
    public function storage($request)
    {
        $input = $request->only('name', 'cn_name', 'pid');
        // 如果没有选择父级 id，则直接排除掉
        if (is_null($input['pid'])) unset($input['pid']);
        // 保存权限数据
        $permission = $this->store($input);

        // 如果此时选择了角色
        if (!empty($request->roles)) {
            foreach ($request->roles as $role) {
                // 循环查询当前所选角色
                $r = Role::findOrFail($role);
                // 给角色赋予权限
                $r->givePermissionTo($input['name']);
            }
        }

        return $permission;

    }

}
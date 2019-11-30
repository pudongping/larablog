<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2019/10/20
 * Time: 0:12
 */

namespace App\Repositories\Auth;

use App\Repositories\BaseRepository;
use App\Models\Auth\User;
use App\Handlers\ImageUploadHandler;
use App\Models\Admin\Authorize\Role;

class UsersRepository extends BaseRepository
{

    protected $model;
    protected $imageUploadHandler;
    protected $roleModel;

    public function __construct(
        User $user,
        ImageUploadHandler $imageUploadHandler,
        Role $roleModel
    ) {
        $this->model = $user;
        $this->imageUploadHandler = $imageUploadHandler;
        $this->roleModel = $roleModel;
    }

    /**
     * 用户列表
     *
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        $search = $request->search;

        $model = $this->model->where(function ($query) use ($search) {
            if (! empty($search)) {
                $query->orWhere('name', 'like', '%' . $search . '%');
            }
        });

        return $this->usePage($model, 'id', 'asc');
    }

    /**
     * 添加用户-数据处理
     *
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function storage($request)
    {
        $allowRoles = $this->validateRoles($request->roles);

        $input = $request->only(['name', 'email']);
        $input['password'] = \Hash::make($request->password);

        \DB::beginTransaction();
        try {
            $user = $this->store($input);
            // 赋予角色
            if ($allowRoles) $user->assignRole($allowRoles);
            user_log('添加用户「' . $user->name . '」');
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
        }

        return $user;
    }

    /**
     * 后台管理修改用户-数据处理
     *
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function adminUpdate($request)
    {
        $allowRoles = $this->validateRoles($request->roles);

        $input = $request->only(['name', 'email']);
        // 如果修改了密码
        if (! is_null($request->password)) {
            $input['password'] = \Hash::make($request->password);
        }

        \DB::beginTransaction();
        try {
            $user = $this->update($request->id, $input);
            // 同步角色，不一致的角色会被移除，替换为数组中提供的角色
            if ($allowRoles) $user->syncRoles($allowRoles);
            user_log('修改用户「' . $user->name . '」：');
            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();
        }

        return $user;
    }

    /**
     * 验证角色有效性
     *
     * @param $roles  需要验证的角色数组
     * @return array  合法的角色数组
     */
    public function validateRoles($roles) : array
    {
        $allowRoles = [];
        if (! empty($roles) && is_array($roles)) {
            // 判断角色有效性
            $rolesInDatabase = $this->roleModel->pluck('name')->toArray();
            // 合法的角色数组
            $allowRoles = array_intersect($roles, $rolesInDatabase);
        }
        return $allowRoles;
    }

    /**
     * 用户个人资料修改
     *
     * @param $request
     * @return mixed  object  当前用户实例
     */
    public function modify($request)
    {
        $data = $request->only(['name', 'email', 'introduction']);

        if ($request->avatar) {
            $result = $this->imageUploadHandler->save($request->avatar, 'avatars', $request->id, 'avatar', 416);
            if ($result) {
                // 存入头像相对路径
                $data['avatar'] = $result['relativePath'];
            }
        }

        $data = $this->update($request->id, $data);

        return $data;
    }

}

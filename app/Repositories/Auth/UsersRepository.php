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

class UsersRepository extends BaseRepository
{

    protected $model;
    protected $imageUploadHandler;

    public function __construct(
        User $user,
        ImageUploadHandler $imageUploadHandler
    ) {
        $this->model = $user;
        $this->imageUploadHandler = $imageUploadHandler;
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
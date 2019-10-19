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

    public function modify($request)
    {
        $data = $request->only(['name', 'email', 'introduction']);

        if ($request->avatar) {
            $result = $this->imageUploadHandler->save($request->avatar, 'avatars', $request->id);
            if ($result) {
                // 存入头像相对路径
                $data['avatar'] = $result['relativePath'];
            }
        }

        $data = $this->update($request->id, $data);

        return $data;
    }

}
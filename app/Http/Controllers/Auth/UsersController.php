<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\User;
use App\Http\Requests\Auth\UserRequest;
use App\Repositories\Auth\UsersRepository;

class UsersController extends Controller
{

    protected $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * 个人信息显示页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('auth.users.show', compact('user'));
    }

    /**
     * 个人信息编辑显示页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('auth.users.edit', compact('user'));
    }

    /**
     * 更新个人信息数据处理
     *
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request)
    {
        $user = $this->usersRepository->modify($request);
        return redirect()->route('users.show', $user->id)
                         ->with('success', $user->name . '的个人资料更新成功！');
    }

}

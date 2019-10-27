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

    public function index()
    {
        $users = User::all();
        dump($users);
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
        // 控制器基类使用了 「AuthorizesRequests」 trait，此 trait 提供了 authorize 方法
        // authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据
        // 此处的 $user 对应 App\Policies\Auth\UserPolicy => updatePolicy() 中的第二个参数
        $this->authorize('updatePolicy', $user);

        return view('auth.users.edit', compact('user'));
    }

    /**
     * 更新个人信息数据处理
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        // 添加授权策略
        $this->authorize('updatePolicy', $user);

        $user = $this->usersRepository->modify($request);
        return redirect()->route('users.show', $user->id)
                         ->with('success', $user->name . '的个人资料更新成功！');
    }

}

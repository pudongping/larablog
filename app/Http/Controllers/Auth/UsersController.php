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
     * 用户列表
     *
     * @param UserRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(UserRequest $request)
    {
        $users = $this->usersRepository->index($request);
        return view('auth.users.index', compact('users'));
    }

    public function create()
    {
        dd(5555);
    }

    public function destroy()
    {

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

    /**
     * 关注用户
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function follow(User $user)
    {
        // 关注策略
        $this->authorize('followPolicy', $user);

        // 关注指定用户
        if (! \Auth::user()->isFollowing($user->id)) {
            \Auth::user()->follow([$user->id]);
        }

        return redirect()->route('users.show', $user->id)
                         ->with('success', '已关注「' . $user->name . '」！');
    }

    /**
     * 取消关注用户
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function unfollow(User $user)
    {
        // 关注策略
        $this->authorize('followPolicy', $user);

        // 取消关注
        if (\Auth::user()->isFollowing($user->id)) {
            \Auth::user()->unfollow([$user->id]);
        }

        return redirect()->route('users.show', $user->id)
                         ->with('success', '已取消对 「' . $user->name . '」 的关注！');
    }

}

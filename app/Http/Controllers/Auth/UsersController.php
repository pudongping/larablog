<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\User;
use App\Http\Requests\Auth\UserRequest;
use App\Repositories\Auth\UsersRepository;
use App\Models\Admin\Authorize\Role;

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

    /**
     * 新增用户-页面渲染
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        return view('auth.users.admin_create_and_update', compact('roles'));
    }

    /**
     * 新增用户-数据处理
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(UserRequest $request)
    {
        $user = $this->usersRepository->storage($request);
        return redirect()->route('users.index')->with('success', '用户 「' . $user->name . ' 」添加成功！');
    }

    /**
     * 后台管理修改用户-页面渲染
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminEdit(User $user)
    {
        $roles = Role::all();
        $rolesNames = $user->getRoleNames()->toArray();
        return view('auth.users.admin_create_and_update', compact('user', 'roles', 'rolesNames'));
    }

    /**
     * 后台管理修改用户-数据处理
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function adminUpdate(UserRequest $request)
    {
        $user = $this->usersRepository->adminUpdate($request);
        return redirect()->route('users.index')->with('success', '用户 「' . $user->name . ' 」修改成功！');
    }

    /**
     * 删除用户
     *
     * @param User $user  选中的用户实例
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if (User::ADMIN_ID === $user->id) {
            return redirect()->route('users.index')->with('danger', '用户 「' . $user->name . ' 」为管理员，不允许删除！');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', '用户 「' . $user->name . ' 」删除成功！');
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
        return redirect()->route('users.show', $user->id)->with('success',  '用户「 ' . $user->name . ' 」的个人资料更新成功！');
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

        return redirect()->route('users.show', $user->id)->with('success', '已关注「' . $user->name . '」！');
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

        return redirect()->route('users.show', $user->id)->with('success', '已取消对 「' . $user->name . '」 的关注！');
    }

}

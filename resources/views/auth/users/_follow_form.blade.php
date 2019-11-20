{{-- 符合 「关注策略」 之后才会显示 取消关注/关注 按钮 --}}
@can('followPolicy', $user)
    <div class="text-right mr-4">
        {{-- 当前登录的用户已经关注了指定用户则显示 「取消关注」 按钮 --}}
        @if (Auth::user()->isFollowing($user->id))
            <form action="{{ route('followers.destroy', $user->id) }}" method="post" style="margin-top: -20px;">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-sm btn-outline-primary">取消关注</button>
            </form>
        @else
            <form action="{{ route('followers.store', $user->id) }}" method="post" style="margin-top: -20px;">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-sm btn-primary">关注</button>
            </form>
        @endif
    </div>
@endcan

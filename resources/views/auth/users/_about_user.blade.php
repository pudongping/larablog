<div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card ">
        <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}">
        <div class="card-body">
            <h5><strong>个人简介</strong></h5>
            <p>{{ $user->introduction }}</p>
            <hr>
            <h5><strong>注册于</strong></h5>
            <p>{{ $user->created_at->diffForHumans() }}</p>
            <hr>
            <h5><strong>最后活跃</strong></h5>
            <p title="{{  $user->last_actived_at }}">{{ $user->last_actived_at->diffForHumans() }}</p>
            <hr>

            <div class="aboutUserTotal">
                <a title="{{ $user->name }} 总共发表了 {{ $user->article_count }} 篇文章！" href="{{ route('users.show', $user->id) }}">
                    <strong>{{ $user->article_count }}</strong>
                    文章
                </a>
                <a title="{{ $user->name }} 关注了 {{ count($user->fanings) }} 位用户！" href="{{ route('users.show', [$user->id, 'tab' => 'fanings']) }}">
                    <strong>{{ count($user->fanings) }}</strong>
                    关注
                </a>
                <a title="有 {{ $user->fans()->count() }} 位粉丝关注了 {{ $user->name }} ！" href="{{ route('users.show', [$user->id, 'tab' => 'fans']) }}">
                    <strong>{{ $user->fans()->count() }}</strong>
                    粉丝
                </a>
            </div>

        </div>
    </div>
</div>

@extends('portal.layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

    <div class="row">

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
                        <a title="{{ $user->name }} 总共发表了 {{ $user->article_count }} 篇文章！" href="#">
                            <strong>{{ $user->article_count }}</strong>
                            文章
                        </a>
                        <a title="{{ $user->name }} 关注了 {{ count($user->fanings) }} 位用户！" href="#">
                            <strong>{{ count($user->fanings) }}</strong>
                            关注
                        </a>
                        <a title="有 {{ $user->fans()->count() }} 位粉丝关注了 {{ $user->name }} ！" href="#">
                            <strong>{{ $user->fans()->count() }}</strong>
                            粉丝
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

            <div class="card ">
                <div class="card-body">
                    <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
                </div>
            </div>

            <hr>

            {{-- 用户发布的内容 --}}
            <div class="card ">

                <div class="card-body">

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}" href="{{ route('users.show', $user->id) }}">
                                Ta 的文章
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">
                                Ta 的回复
                            </a>
                        </li>
                    </ul>

                    @if (if_query('tab', 'replies'))
                        @include('auth.users._replies', ['replies' => $user->replies()->with('article')->orderBy('id', 'desc')->paginate(5)])
                    @else
                        @include('auth.users._articles', ['articles' => $user->articles()->recent()->paginate(5)])
                    @endif
                </div>

            </div>

        </div>

    </div>

@stop

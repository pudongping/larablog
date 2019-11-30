@extends('portal.layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

    <div class="row">

        @include('auth.users._about_user')

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

            <div class="card">
                <div class="card-body">
                    <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
                    @if (Auth::check())
                        @include('auth.users._follow_form')
                    @endif
                </div>
            </div>

            <hr>

            {{-- 用户发布的内容 --}}
            <div class="card ">

                <div class="card-body">

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link bg-transparent {{ active_class(if_query('tab', null) || if_query('tab', 'articles')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'articles']) }}">
                                Ta 的文章
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">
                                Ta 的回复
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'fanings')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'fanings']) }}">
                                Ta 的关注
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'fans')) }}" href="{{ route('users.show', [$user->id, 'tab' => 'fans']) }}">
                                Ta 的粉丝
                            </a>
                        </li>
                    </ul>

                    @if (if_query('tab', 'replies'))
                        @include('auth.users._replies', ['replies' => $user->replies()->with('article')->orderBy('id', 'desc')->paginate(5)])
                    @elseif(if_query('tab', 'fanings'))
                        @include('auth.users._show_follow', ['users' => $user->fanings()->paginate(5)])
                    @elseif(if_query('tab', 'fans'))
                        @include('auth.users._show_follow', ['users' => $user->fans()->paginate(5)])
                    @else
                        @include('auth.users._articles', ['articles' => $user->articles()->recent()->paginate(5)])
                    @endif
                </div>

            </div>

        </div>

    </div>

@stop

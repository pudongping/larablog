@extends('portal.layouts.app')

@section('title', '我的通知')

@section('content')
    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">

                    <h3 class="text-xs-center">
                        <i class="far fa-bell" aria-hidden="true"></i> 我的通知
                    </h3>
                    <hr>

                    @if ($notifications->count())

                        {{--通知数据库表的 Type 字段保存的是通知类全称，
                        如 ：App\Notifications\ArticleReplied 。
                        Str::snake(class_basename($notification->type)) 渲染以后会是 —— article_replied。
                        class_basename() 方法会取到 ArticleReplied，Laravel 的辅助方法 Str::snake() 会字符串格式化为下划线命名。--}}
                        <div class="list-unstyled notification-list">
                            @foreach ($notifications as $notification)
                                @include('portal.notifications.types._' . Str::snake(class_basename($notification->type)))
                            @endforeach

                            {!! $notifications->render() !!}
                        </div>

                    @else
                        <div class="empty-block">没有消息通知！</div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop
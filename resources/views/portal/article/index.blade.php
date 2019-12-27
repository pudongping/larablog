@extends('portal.layouts.app')

@section('title', isset($category) ? $category->name : '文章列表')

@section('content')

    <div class="row mb-5">

        <div class="col-lg-9 col-md-9 article-list">

            @if (isset($category))
                <div class="alert alert-info" role="alert">
                    {{ $category->name }} : {{ $category->description }}
                </div>
            @endif

            <div class="card ">

                <div class="card-header bg-transparent">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link {{ active_class(! if_query('order', 'recent')) }}" href="{{ Request::url() }}?order=default">最后回复</a></li>
                        <li class="nav-item"><a class="nav-link {{ active_class(if_query('order', 'recent')) }}" href="{{ Request::url() }}?order=recent">最新发布</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    {{-- 文章列表 --}}
                    @include('portal.article._article_list', ['articles' => $articles])
                    {{-- 分页 --}}
                    <div class="mt-5">
                        {{-- 因为分页会自动追加 page 参数，因此需要先去除掉 page 参数，然后将其他的参数追加到 url 中 --}}
                        {!! $pageLinks ?? $articles->appends(request()->except('page'))->render() !!}
                    </div>
                </div>

            </div>

        </div>

        {{-- 文章列表右侧部分 --}}
        <div class="col-lg-3 col-md-3 sidebar">
            @include('portal.article._sidebar')
        </div>

    </div>

@endsection

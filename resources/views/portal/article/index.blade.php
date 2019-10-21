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
                        <li class="nav-item"><a class="nav-link active" href="{{ Request::url() }}?order=default">最后回复</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ Request::url() }}?order=recent">最新发布</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    {{-- 文章列表 --}}
                    @include('portal.article._article_list', ['articles' => $articles])
                    {{-- 分页 --}}
                    <div class="mt-5">
                        {!! $articles->appends(Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('portal.article._sidebar')
        </div>

    </div>

@endsection
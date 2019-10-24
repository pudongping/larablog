@extends('portal.layouts.app')

@section('title', $article->title)
@section('description', $article->excerpt)

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
            <div class="card ">
                <div class="card-body">
                    <div class="text-center">
                        作者：{{ $article->user->name }}
                    </div>
                    <hr>
                    <div class="media">
                        <div align="center">
                            <a href="{{ route('users.show', $article->user->id) }}">
                                <img class="thumbnail img-fluid" src="{{ $article->user->avatar }}" width="300px" height="300px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 article-content">

            <div class="card ">
                <div class="card-body">
                    <h1 class="text-center mt-3 mb-3">
                        {{ $article->title }}
                    </h1>

                    <div class="article-meta text-center text-secondary">
                        {{ $article->created_at->diffForHumans() }}
                        ⋅
                        <i class="far fa-comment"></i>
                        {{ $article->reply_count }}
                    </div>

                    <div class="article-body mt-4 mb-4">
                        {!! $article->body !!}
                    </div>

                    @can('updatePolicy', $article)
                        <div class="operate">
                            <hr>
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                                <i class="far fa-edit"></i> 编辑
                            </a>
                            <form action="{{ route('articles.destroy', $article->id) }}" method="post"
                                  style="display: inline-block;"
                                  onsubmit="return confirm('您确定要删除吗？');">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-outline-secondary btn-sm">
                                    <i class="far fa-trash-alt"></i> 删除
                                </button>
                            </form>
                        </div>
                    @endcan

                </div>
            </div>

            {{-- 用户回复列表 --}}
            <div class="card topic-reply mt-4">
                <div class="card-body">
                    @include('portal.article._reply_box', ['article' => $article])
                    @include('portal.article._reply_list', ['replies' => $article->replies()->with('user')->get()])
                </div>
            </div>

        </div>
    </div>
@stop

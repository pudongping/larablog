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

                    <div class="text-center mb-2">
                        @if(count($article->tags))
                            @foreach($article->tags as $tag)
                                <a href="{{ route('tags.show', [$tag->id]) }}" title="{{ $tag->description }}" class="text-muted"><i class="fa fa-tags" aria-hidden="true"></i> {{$tag->name}} </a>
                            @endforeach
                        @endif
                    </div>

                    <div class="article-meta text-center text-secondary">
                        {{ $article->created_at->diffForHumans() }}
                        ⋅
                        <i class="far fa-comment"></i>
                        {{ $article->reply_count }}
                    </div>

                    <div class="mt-4 mb-4 article-show-body">
                        {!! $article->body !!}
                    </div>

                    <div class="operate">
                        <hr>
                        @can('updatePolicy', $article)
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
                                <i class="far fa-edit"></i> 编辑
                            </a>

                            <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#del{{ $article->id }}">
                                <i class="far fa-trash-alt"></i> 删除
                            </button>
                            @component('shared._alert', ['modalId' => 'del' . $article->id])
                                @slot('modalTitle')
                                    删除文章
                                @endslot
                                @slot('modalBody')
                                    确定删除 「 {{ $article->title }} 」吗？
                                @endslot
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-danger" type="submit" name="button">删除</button>
                                </form>
                            @endcomponent

                        @endcan
                        <a href="{{ route('articles.show', [$article->id, 'is_markdown' => 1]) }}" class="btn btn-outline-secondary btn-sm pull-right" role="button">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i> Markdown 文本
                        </a>
                    </div>

                </div>
            </div>

            {{-- 用户回复列表 --}}
            <div class="card topic-reply mt-4">
                <div class="card-body">

                    {{-- 当用户已经登录之后，才显示评论框 --}}
                    @includeWhen(Auth::check(), 'portal.article._reply_box', ['article' => $article])

                    @include('portal.article._reply_list', ['replies' => $article->replies()->with('user', 'article')->orderBy('replies.id', 'desc')->paginate(5)])
                </div>
            </div>

        </div>
    </div>
@stop

@extends('admin.layouts.sapp')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">
        <i class="fa fa-book" aria-hidden="true"></i> 文章
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4" >

        <div class="card-header py-3">

            <a href="{{ route('articles.create') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">添加文章</span>
            </a>

            <!-- Topbar Search -->
            <form action="{{ route('articles.admin_index') }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" name="search" style="width: 280px;" class="form-control bg-light border-1 small" placeholder="关键词，如：标题、摘要、作者" aria-label="Search" aria-describedby="basic-addon2" value="{{ request()->search }}">

                    <div class="form-group ml-3">
                        <select class="form-control" name="category_id">
                            <option value="">分类</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request()->category_id ?? false == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group ml-3">
                        <select name="tag_id" class="form-control">
                            <option value="">标签</option>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{ request()->tag_id ?? false == $tag->id ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <a href="{{ route('articles.admin_index') }}" class="btn btn-info btn-icon-split">
                <span class="text">清空</span>
            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>标题</th>
                        <th>摘要</th>
                        <th>作者</th>
                        <th>分类</th>
                        <th>标签</th>
                        <th>评论</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>标题</th>
                        <th>摘要</th>
                        <th>作者</th>
                        <th>分类</th>
                        <th>标签</th>
                        <th>评论</th>
                        <th>操作</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->excerpt }}</td>
                            <td>
                                <img src="{{ $article->user->avatar }}" class="img-circle mb-1" style="width: 40px;"><br>
                                {{ $article->user->name }}
                            </td>
                            <td>{{ $article->category->name }}</td>
                            <td>{{ str_replace(',', ' | ', str_replace(['[', ']', '"'], '', $article->tags->pluck('name'))) }}</td>
                            <td>{{ $article->reply_count }}</td>

                            <td>

                                <a href="{{ route('articles.admin_edit', $article->id) }}" class="btn btn-info btn-circle btn-sm" style="float: left; margin-right: 8px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#del{{$article->id}}">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                @component('shared._alert', ['modalId' => 'del' . $article->id])
                                    @slot('modalTitle')
                                        删除文章
                                    @endslot
                                    @slot('modalBody')
                                        确定删除 「 {{ $article->title }} 」吗？
                                    @endslot
                                    <form action="{{ route('articles.admin_destroy', $article->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger" type="submit" name="button">删除</button>
                                    </form>
                                @endcomponent

                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            {{-- 分页 --}}
            <div class="mt-2">
                {!! $articles->appends(Request::input())->links() !!}
            </div>

        </div>
    </div>

@endsection

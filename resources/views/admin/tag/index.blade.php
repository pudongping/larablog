@extends('admin.layouts.sapp')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">
        <i class="fa fa-tags" aria-hidden="true"></i> 标签
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4" >

        <div class="card-header py-3">

            <a href="{{ route('tags.create') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">添加标签</span>
            </a>

            <!-- Topbar Search -->
            <form action="{{ route('tags.index') }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-1 small" placeholder="关键词，如：名称，描述" aria-label="Search" aria-describedby="basic-addon2" value="{{ request()->search }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <a href="{{ route('tags.index') }}" class="btn btn-info btn-icon-split">
                <span class="text">清空</span>
            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>名称</th>
                        <th>描述</th>
                        <th>文章数</th>
                        <th>样式</th>
                        <th>排序编号</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>名称</th>
                        <th>描述</th>
                        <th>文章数</th>
                        <th>样式</th>
                        <th>排序编号</th>
                        <th>操作</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->description }}</td>
                            <td>{{ $tag->article_count }}</td>
                            <td>{{ $tag->btn_class }}</td>
                            <td>{{ $tag->order }}</td>

                            <td>

                                <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-info btn-circle btn-sm" style="float: left; margin-right: 8px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#del{{$tag->id}}">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                @component('shared._alert', ['modalId' => 'del' . $tag->id])
                                    @slot('modalTitle')
                                        删除标签
                                    @endslot
                                    @slot('modalBody')
                                        确定删除 「 {{ $tag->name }} 」吗？
                                    @endslot
                                    <form action="{{ route('tags.destroy', $tag->id) }}" method="POST">
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
                {!! $tags->appends(Request::input())->links() !!}
            </div>

        </div>
    </div>

@endsection

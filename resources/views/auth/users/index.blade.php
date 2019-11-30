@extends('admin.layouts.sapp')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">
        <i class="fa fa-users" aria-hidden="true"></i> 用户
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <a href="{{ route('users.create') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">添加用户</span>
            </a>

            <a href="{{ route('roles.index') }}" class="btn btn-success btn-icon-split">
                <span class="text">角色</span>
            </a>
            <a href="{{ route('permissions.index') }}" class="btn btn-success btn-icon-split">
                <span class="text">权限</span>
            </a>

            <!-- Topbar Search -->
            <form action="{{ route('users.index') }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-1 small" placeholder="关键词，如：昵称" aria-label="Search" aria-describedby="basic-addon2" value="{{ request()->search }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <a href="{{ route('users.index') }}" class="btn btn-info btn-icon-split">
                <span class="text">清空</span>
            </a>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>昵称</th>
                        <th>邮箱</th>
                        <th>头像</th>
                        <th>未读通知数量</th>
                        <th>发布文章总数</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>昵称</th>
                        <th>邮箱</th>
                        <th>头像</th>
                        <th>未读通知数量</th>
                        <th>发布文章总数</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <img src="{{ $user->avatar }}" class="img-circle" style="width: 40px;">
                            </td>
                            <td>{{ $user->notification_count }}</td>
                            <td>{{ $user->article_count }}</td>
                            <td>{{ $user->created_at }}</td>

                            <td>

                                <a href="{{ route('users.admin_edit', $user->id) }}" class="btn btn-info btn-circle btn-sm" style="float: left; margin-right: 8px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#del{{$user->id}}">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                @component('shared._alert', ['modalId' => 'del' . $user->id])
                                    @slot('modalTitle')
                                        删除用户
                                    @endslot
                                    @slot('modalBody')
                                        确定删除 「 {{ $user->name }} 」吗？
                                    @endslot
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
                {!! $users->appends(Request::except('page'))->render() !!}
            </div>

        </div>
    </div>

@endsection

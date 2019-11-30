@extends('admin.layouts.sapp')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">
        <i class="fa fa-key"></i> 权限
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">添加权限</span>
            </a>

            <a href="{{ route('users.index') }}" class="btn btn-success btn-icon-split">
                <span class="text">用户</span>
            </a>
            <a href="{{ route('roles.index') }}" class="btn btn-success btn-icon-split">
                <span class="text">角色</span>
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>权限</th>
                        <th>名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>权限</th>
                        <th>名称</th>
                        <th>操作</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission['id'] }}</td>
                        <td>{{ $permission['name'] }}</td>
                        <td>{{ $permission['cn_name'] }}</td>
                        <td>

                            <a href="{{ route('permissions.edit', $permission['id']) }}" class="btn btn-info btn-circle btn-sm" style="float: left; margin-right: 8px;">
                                <i class="fas fa-edit"></i>
                            </a>

                            <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#del{{$permission['id']}}">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            @component('shared._alert', ['modalId' => 'del' . $permission['id']])
                                @slot('modalTitle')
                                    删除权限
                                @endslot
                                @slot('modalBody')
                                    确定删除 「 {{ $permission['name'] }} 」吗？
                                @endslot
                                <form action="{{ route('permissions.destroy', $permission['id']) }}" method="POST">
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
        </div>
    </div>

@endsection

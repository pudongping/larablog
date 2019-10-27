@extends('admin.layouts.sapp')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">
        <i class="fa fa-key"></i> 权限
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        @include('shared._messages')

        <div class="card-header py-3">

            <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">添加权限</span>
            </a>

            <a href="#" class="btn btn-success btn-icon-split">
                <span class="text">用户</span>
            </a>
            <a href="#" class="btn btn-success btn-icon-split">
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
                        <th>守卫名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>权限</th>
                        <th>名称</th>
                        <th>守卫名称</th>
                        <th>操作</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission['id'] }}</td>
                        <td>{{ $permission['name'] }}</td>
                        <td>{{ $permission['cn_name'] }}</td>
                        <td>{{ $permission['guard_name'] }}</td>
                        <td>

                            <a href="{{ route('permissions.edit', $permission['id']) }}" class="btn btn-info btn-circle btn-sm" style="float: left; margin-right: 8px;">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('permissions.destroy', $permission['id']) }}"
                                  onsubmit="return confirm('确定要删除此权限？');"
                                  method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-circle btn-sm">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
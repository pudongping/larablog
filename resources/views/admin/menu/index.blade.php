@extends('admin.layouts.sapp')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">
        <i class="fa fa-bars" aria-hidden="true"></i> 菜单
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4" >

        <div class="card-header py-3">

            <a href="{{ route('menus.create') }}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">添加菜单</span>
            </a>

            <!-- Topbar Search -->
            <form action="{{ route('menus.index') }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-1 small" placeholder="关键词，如：名称、url" aria-label="Search" aria-describedby="basic-addon2" value="{{ request()->search }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <a href="{{ route('menus.index') }}" class="btn btn-info btn-icon-split">
                <span class="text">清空</span>
            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>父级 id</th>
                        <th>名称</th>
                        <th>链接地址</th>
                        <th>权限</th>
                        <th>图标</th>
                        <th>描述</th>
                        <th>排序</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>父级 id</th>
                        <th>名称</th>
                        <th>链接地址</th>
                        <th>权限</th>
                        <th>图标</th>
                        <th>描述</th>
                        <th>排序</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach($menus as $menu)
                        <tr>
                            <td>{{ $menu['id'] }}</td>
                            <td>{{ $menu['pid'] }}</td>
                            <td>{{ $menu['name'] }}</td>
                            <td>{{ $menu['link'] }}</td>
                            <td>{{ $menu['auth'] }}</td>
                            <td><i class="{{ $menu['icon'] }}"></i></td>
                            <td>{{ $menu['description'] }}</td>
                            <td>{{ $menu['sort'] }}</td>
                            <td>{{ $menu['created_at'] }}</td>

                            <td>

                                <a href="{{ route('menus.edit', $menu['id']) }}" class="btn btn-info btn-circle btn-sm" style="float: left; margin-right: 8px;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#del{{$menu['id']}}">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                @component('shared._alert', ['modalId' => 'del' . $menu['id']])
                                    @slot('modalTitle')
                                        确定要删除此菜单吗？
                                    @endslot
                                    @slot('modalBody')
                                        如果不想删除，请点击取消！
                                    @endslot
                                    <form action="{{ route('menus.destroy', $menu['id']) }}" method="POST">
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
                {!! $pageLinks !!}
            </div>

        </div>
    </div>

@endsection

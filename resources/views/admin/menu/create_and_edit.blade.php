@extends('admin.layouts.sapp')

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-3"></div>

        <!-- First Column -->
        <div class="col-lg-6">

            <!-- Custom Font Size Utilities -->
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        @if($menu->id ?? false)
                            编辑菜单
                        @else
                            添加菜单
                        @endif
                    </h6>
                </div>

                <div class="card-body">

                    @if($menu->id ?? false)
                        <form class="form-horizontal" action="{{ route('menus.update', $menu->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $menu->id }}">
                    @else
                        <form class="form-horizontal" action="{{ route('menus.store') }}" method="POST" accept-charset="UTF-8">
                    @endif
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('shared._error')

                        <div class="form-group">
                            <div class="col-sm-10">
                                <select class="form-control" name="pid" required>
                                    <option value="0" hidden disabled {{ $menu->pid ?? false ? '' : 'selected' }}>请选择父级菜单，默认为一级菜单</option>
                                    @foreach ($topLevelMenus as $value)
                                        <option value="{{ $value['id'] }}"
                                                @if(isset($menu->pid))
                                                    {{ $menu->pid == $value['id'] ? 'selected' : '' }}
                                                @endif
                                            >
                                            {{ $value['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="name" value="{{ old('name', $menu->name ?? '') }}" placeholder="请填写菜单名称" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">路由名称</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="link" value="{{ old('link', $menu->link ?? '') }}" placeholder="请填写路由名称，如：menus.index 一级菜单可不填写"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">所受权限影响</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="auth" value="{{ old('auth', $menu->auth ?? '') }}" placeholder="如：create-menu，多个权限用 | 分隔，如：create-menu|update-menu"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">图标</label>
                            <a href="http://www.fontawesome.com.cn/faicons/">图标任意门</a>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="icon" value="{{ old('icon', $menu->icon ?? '') }}" placeholder="如：fas fa-fw fa-folder 非一级菜单，可不用填写" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">描述信息</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="description" value="{{ old('description', $menu->description ?? '') }}" placeholder="非一级菜单，可不填写" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="sort" value="{{ old('sort', $menu->sort ?? 0) }}" placeholder="数字越大，排序越靠前" />
                            </div>
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
                                <i class="far fa-save mr-2" aria-hidden="true"></i> 保存
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection

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
                    <h6 class="m-0 font-weight-bold text-primary"><i class='fa fa-key'></i> 编辑角色： {{$role->name}}</h6>
                </div>

                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('roles.update', $role->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="{{ $role->id }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('shared._error')

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">角色</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="name" value="{{ old('name', $role->name ) }}" placeholder="请填写角色，例如：Maintainer" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="cn_name" value="{{ old('cn_name', $role->cn_name ) }}" placeholder="请填写角色中文名称" required />
                            </div>
                        </div>

                        {{-- 如果当前已经存在角色的话 --}}
                        @if(!empty($permissions))
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">分配权限</label>
                                <div class="col-sm-10">
                                    {{-- 复选框 --}}
                                    <div class="checkbox">
                                        <label>
                                            @foreach($permissions as $permission)
                                                <input type="checkbox"  name="permissions[]"
                                                       value="{{ $permission['id'] }}" {{ isset($checkedPermissions[$permission['id']]) ? 'checked' : '' }}>
                                                {{ $permission['cn_name'] }} - {{ $permission['name'] }}
                                                <br>
                                            @endforeach
                                        </label>
                                    </div>

                                </div>
                            </div>
                        @endif

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

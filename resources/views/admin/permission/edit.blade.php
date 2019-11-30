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
                    <h6 class="m-0 font-weight-bold text-primary"><i class='fa fa-key'></i> 编辑权限： {{$permission->name}}</h6>
                </div>

                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('permissions.update', $permission->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="{{ $permission->id }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('shared._error')

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">权限</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="name" value="{{ old('name', $permission->name ) }}" placeholder="请填写权限，例如：manage_settings" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="cn_name" value="{{ old('cn_name', $permission->cn_name ) }}" placeholder="请填写权限中文名称" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">上级归属</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="pid">
                                    <option value="">请选择上级归属</option>
                                    @foreach($permissions as $val)
                                        <option value="{{ $val['id'] }}" >{{ $val['cn_name'] }} - {{ $val['name'] }}</option>
                                    @endforeach
                                </select>
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

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
                        @if($category->id ?? false)
                            编辑分类
                        @else
                            添加分类
                        @endif
                    </h6>
                </div>

                <div class="card-body">

                    @if($category->id ?? false)
                        <form class="form-horizontal" action="{{ route('categories.update', $category->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $category->id }}">
                            @else
                                <form class="form-horizontal" action="{{ route('categories.store') }}" method="POST" accept-charset="UTF-8">
                                    @endif
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    @include('shared._error')

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">名称</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="name" value="{{ old('name', $category->name ?? '') }}" placeholder="请填写分类名称" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label">分类描述</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="description" value="{{ old('description', $category->description ?? '') }}" placeholder="请填写分类描述信息" required />
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

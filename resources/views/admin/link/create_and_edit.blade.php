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
                        @if($link->id ?? false)
                            编辑资源推荐
                        @else
                            添加资源推荐
                        @endif
                    </h6>
                </div>

                <div class="card-body">

                    @if($link->id ?? false)
                        <form class="form-horizontal" action="{{ route('links.update', $link->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $link->id }}">
                            @else
                                <form class="form-horizontal" action="{{ route('links.store') }}" method="POST" accept-charset="UTF-8">
                                    @endif
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    @include('shared._error')

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">名称</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="title" value="{{ old('title', $link->title ?? '') }}" placeholder="请填写资源名称" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label">资源链接地址</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="link" value="{{ old('link', $link->link ?? '') }}" placeholder="请填写完整的链接地址，需加上 http:// 或 https://" required />
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

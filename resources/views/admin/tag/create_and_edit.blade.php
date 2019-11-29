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
                        @if($tag->id ?? false)
                            编辑标签
                        @else
                            添加标签
                        @endif
                    </h6>
                </div>

                <div class="card-body">

                    @if($tag->id ?? false)
                        <form class="form-horizontal" action="{{ route('tags.update', $tag->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $tag->id }}">
                            @else
                                <form class="form-horizontal" action="{{ route('tags.store') }}" method="POST" accept-charset="UTF-8">
                                    @endif
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    @include('shared._error')

                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <select class="form-control" name="btn_class" required>
                                                <option value="info" hidden disabled {{ $tag->btn_class ?? false ? '' : 'selected' }}>请选择标签颜色样式</option>
                                                @foreach ($btnClasses as $btnClass)
                                                    <option value="{{ $btnClass }}"
                                                    @if(isset($tag->btn_class))
                                                        {{ $tag->btn_class == $btnClass ? 'selected' : '' }}
                                                        @endif
                                                    >
                                                        {{ $btnClass }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">名称</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="name" value="{{ old('name', $tag->name ?? '') }}" placeholder="请填写标签名称" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label">标签描述</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="description" value="{{ old('description', $tag->description ?? '') }}" placeholder="请填写标签描述信息" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label">排序</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" name="order" value="{{ old('order', $tag->order ?? 0) }}" placeholder="数字越大，排序越靠前" />
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

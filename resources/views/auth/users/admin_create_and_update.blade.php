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
                    <h6 class="m-0 font-weight-bold text-primary"><i class='fa fa-user-plus'></i>
                    @if($user->id ?? false)
                        修改用户：{{ $user->name }}
                    @else
                        添加新用户
                    @endif
                    </h6>
                </div>

                <div class="card-body">

                    @if($user->id ?? false)
                        <form class="form-horizontal" action="{{ route('users.admin_update', $user->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                    @else
                        <form class="form-horizontal" action="{{ route('users.store') }}" method="POST" accept-charset="UTF-8">
                    @endif

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('shared._error')

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">昵称</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="请填写用户昵称" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">邮箱</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="请填写邮箱" required />
                            </div>
                        </div>

                        {{-- 如果当前已经存在角色的话 --}}
                        @if(!empty($roles))
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">分配角色</label>
                                <div class="col-sm-10">
                                    {{-- 复选框 --}}
                                    <div class="checkbox">
                                        <label>
                                            @foreach($roles as $role)
                                                <input type="checkbox"  name="roles[]"
                                                       value="{{ $role->name }}"
                                                       @php
                                                        if (isset($rolesNames) && ! empty($rolesNames)){
                                                           if (in_array($role->name, $rolesNames)) {
                                                                echo 'checked';
                                                           }
                                                        }
                                                       @endphp
                                                >
                                                {{ $role->cn_name }} - {{ $role->name }}
                                                <br>
                                            @endforeach
                                        </label>
                                    </div>

                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="password" name="password" {{ $user->id ?? false ? '' : 'required' }}  placeholder="请输入密码" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">确认密码</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password_confirmation" {{ $user->id ?? false ? '' : 'required' }} placeholder="请重复输入密码" />
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

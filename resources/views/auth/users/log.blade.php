@extends('portal.layouts.app')

@section('title', $user->name . ' 的操作日志')

@section('content')

    <div class="row">

        @include('auth.users._about_user')

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">

            <div class="card">
                <div class="card-body">
                    <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>的操作日志</small></h1>
                </div>
            </div>

            <hr>

            {{-- 用户发布的内容 --}}
            <div class="card ">

                <div class="card-body">

                    @if (count($logs))

                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                <tr>
                                    <th>访问 IP</th>
                                    <th>设备来源</th>
                                    <th>描述信息</th>
                                    <th>操作时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($logs as $log)
                                <tr>
                                    <td>{{ $log->client_ip }}</td>
                                    <td>{{ Arr::first(json_decode($log->header, true)['user-agent']) }}</td>
                                    <td>{!! $log->description !!}</td>
                                    <td>{{ $log->created_at }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else
                        <div class="empty-block" style="margin-top: 20px">暂无数据 ~_~ </div>
                    @endif

                    {{-- 分页 --}}
                    <div class="mt-4 pt-1">
                        {!! $logs->appends(Request::except('page'))->render() !!}
                    </div>

                </div>

            </div>

        </div>

    </div>

@stop

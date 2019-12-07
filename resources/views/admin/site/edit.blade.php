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
                    <h6 class="m-0 font-weight-bold text-primary"><i class='fa fa-cogs'></i>  站点设置</h6>
                </div>

                <div class="card-body">

                    <form class="form-horizontal" action="{{ route('sites.update') }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('shared._error')

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">站点名称</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="site_name" value="{{ old('site_name', $site['site_name'] ) }}" placeholder="请填写站点名称" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">站长昵称</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="founder_nickname" value="{{ old('founder_nickname', $site['founder_nickname'] ) }}" placeholder="请填写站长昵称" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">网站地址</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" name="founder_website" value="{{ old('founder_website', $site['founder_website'] ) }}" placeholder="请填写完整的链接地址，需加上 http:// 或 https://" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">联系人邮箱</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="contact_email" value="{{ old('contact_email', $site['contact_email'] ) }}" autocomplete="email"  placeholder="请填写联系人邮箱">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">SEO - 描述信息</label>
                            <div class="col-sm-10">
                                <textarea name="seo_description" class="form-control" rows="3" placeholder="请填入至少三个字符的内容。">{{ old('seo_description', $site['seo_description'] ) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">SEO - 关键词</label>
                            <div class="col-sm-10">
                                <textarea name="seo_keyword" class="form-control" rows="3" placeholder="请填入至少三个字符的内容。">{{ old('seo_keyword', $site['seo_keyword'] ) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">网站备案号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="record_n_varchar" value="{{ old('record_n_varchar', $site['record_n_varchar'] ) }}"  placeholder="请填写网站备案号">
                            </div>
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary" style="margin-left: 10px;">
                                <i class="far fa-save mr-2" aria-hidden="true"></i> 保存
                            </button>

                            <a href="{{ route('clear_cache') }}" class="btn btn-info btn-icon-split">
                                <span class="text"><i class="fa fa-paint-brush mr-2" aria-hidden="true"></i>更新系统缓存</span>
                            </a>

                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection

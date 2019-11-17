<!DOCTYPE html>

{{-- 根据 config/app.php => locale 切换语言 --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- 所有页面所需公共头部 --}}
    @include('shared._common_meta')

    @section('content')
        404 - {{ site_setting('site_name') ?: config('app.name') }}
    @endsection

  {{-- css 样式 --}}
  @include('shared.sb-css-js._s_css')

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

      <!-- Begin Page Content -->
      <div class="container-fluid">
        {{-- 此处填充内容 --}}

        <!-- 404 Error Text -->
          <div class="text-center" style="margin-top: 150px;">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">访问页面未找到！</p>
            <p class="text-gray-500 mb-0">如果您觉得这是一个 Bug，<a href="mailto:{{ site_setting('contact_email') }}" style="text-decoration: none;">请联系我们！</a></p>
            <a href="{{ url('/') }}" style="text-decoration: none;">回到主页</a>
          </div>

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

  {{-- 底部 --}}
  <!-- Footer -->
  @include('admin.layouts._sfooter')
  <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->


</div>
<!-- End of Page Wrapper -->

{{-- js --}}
@include('shared.sb-css-js._s_js')

</body>

{{-- 动态获取全屏宽高 --}}
<script type="text/javascript">
    var screenHeight = document.documentElement.clientHeight;
    var screenWidth = document.documentElement.clientWidth;
    var wrapper = document.getElementById('wrapper');
    wrapper.style.width = screenWidth+"px";
    wrapper.style.height = screenHeight+"px";
</script>

</html>


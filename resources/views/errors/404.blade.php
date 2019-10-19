<!DOCTYPE html>

{{-- 根据 config/app.php => locale 切换语言 --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>404 - {{ config('app.name', '的个人博客') }}</title>

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
      <div class="container-fluid" style="height: 550px">
        {{-- 此处填充内容 --}}

        <!-- 404 Error Text -->
          <div class="text-center" style="margin-top: 100px;">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">访问页面未找到！</p>
            <p class="text-gray-500 mb-0">如果您觉得这是一个 Bug，请联系我们！</p>
            <a href="{{ url('/') }}">回到主页</a>
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

</html>

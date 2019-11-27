<!DOCTYPE html>

{{-- 根据 config/app.php => locale 切换语言 --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- 所有页面所需公共头部 --}}
    @include('shared._common_meta')

    {{-- css 样式 --}}
    @include('shared.sb-css-js._s_css')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.layouts._menu')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('admin.layouts._stopbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    {{-- 加载消息提示弹框 --}}
                    @include('shared._messages')

                    {{-- 此处填充内容 --}}
                    @yield('content')
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


<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
@include('admin.layouts._suser_logout_modal')

{{-- js --}}
@include('shared.sb-css-js._s_js')

</body>

</html>

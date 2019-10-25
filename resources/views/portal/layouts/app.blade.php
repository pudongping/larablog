<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    {{-- 所有页面所需公共头部 --}}
    @include('shared._common_meta')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/theme/startbootstrap-sb-admin-2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/theme/startbootstrap-sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    @yield('styles')
</head>
<body>

    <div id="app" class="{{ route_class() }}-page">

        {{-- 头部 --}}
        @include('portal.layouts._header')

        <div class="container">
            {{-- 提示信息 --}}
            @include('shared._messages')
            {{-- 内容 --}}
            @yield('content')
        </div>

        {{-- 底部 --}}
        @include('portal.layouts._footer')

    </div>

    {{-- Scripts --}}
    <script src="{{ mix('js/app.js') }}"></script>

    @yield('scripts')
</body>
</html>

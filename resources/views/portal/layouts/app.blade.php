<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    {{-- 方便前端的 JavaScript 脚本获取 CSRF 令牌 --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'warmwave'))-Alex的个人博客</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
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

</body>
</html>

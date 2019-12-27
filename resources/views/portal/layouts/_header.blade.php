<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand " href="{{ url('/') }}">
            {{ site_setting('site_name') ?: config('app.name', '我的个人博客') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @php
                    $baseActive = !isset($category) ? 'active' : '';
                @endphp
                <li class="nav-item {{ $baseActive ?? '' }}"><a class="nav-link" href="{{ route('articles.index') }}">文章</a></li>

                @if (isset($allCategories))
                    @foreach ($allCategories as $cId => $cName)
                        @php
                            if (isset($category)) {
                                $isActive = $cId == $category->id ? 'active' : '';
                            }
                        @endphp
                        <li class="nav-item {{ $isActive ?? '' }}"><a class="nav-link" href="{{ route('categories.show', $cId) }}">{{ $cName }}</a></li>
                    @endforeach
                @endif

            </ul>

            <ul class="navbar-nav mr-auto">
                <form action="{{ route('articles.index') }}" method="GET" class="navbar-search" id="articleSearch">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control small article-search-input" aria-label="Search" placeholder="搜索" value="{{ request()->search }}">
                        <button class="btn article-search-btn" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </form>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">

                <!-- Authentication Links -->
                @guest
                    {{-- 当前用户没有登陆 --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
                @else
                    {{-- 发布文章按钮 --}}
                    <li class="nav-item">
                        <a class="nav-link mt-1 mr-3 font-weight-bold" href="{{ route('articles.create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </li>

                    {{-- 消息通知徽章 --}}
                    <li class="nav-item notification-badge">
                        <a class="nav-link mr-3 badge badge-pill badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'secondary' }} text-white" href="{{ route('notifications.index') }}">
                            {{ Auth::user()->notification_count }}
                        </a>
                    </li>

                    {{-- 用户已经登陆 --}}
                    @include('admin.layouts.stopbar-navbar._suser_information')

                @endguest

            </ul>
        </div>
    </div>
</nav>

{{-- 退出登录 modal 框 --}}
@include('admin.layouts._suser_logout_modal')

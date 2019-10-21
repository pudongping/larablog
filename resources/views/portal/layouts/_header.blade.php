<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand " href="{{ url('/') }}">
            {{ config('app.name', 'Alex的个人博客') }}
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

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">

                <!-- Authentication Links -->
                @guest
                    {{-- 当前用户没有登陆 --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
                @else
                    {{-- 用户已经登陆 --}}
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">
                                <i class="far fa-user mr-2"></i>
                                个人中心
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">
                                <i class="far fa-edit mr-2"></i>
                                编辑资料
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" id="logout" href="#">
                                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('您确定要退出吗？');">
                                    {{ csrf_field() }}
                                    <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                                </form>
                            </a>
                        </div>

                    </li>
                @endguest

            </ul>
        </div>
    </div>
</nav>
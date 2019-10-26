<!-- Nav Item - User Information -->
<li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
        <img class="img-profile rounded-circle" src="{{ Auth::user()->avatar }}" width="30px" height="30px">
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            个人中心
        </a>
        <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">
            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
            编辑资料
        </a>
        <a class="dropdown-item" href="#">
            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
            访问日志
        </a>
        <div class="dropdown-divider"></div>
        @can('manage_contents')
            <a class="dropdown-item" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt mr-2"></i>
                管理后台
            </a>
            <div class="dropdown-divider"></div>
        @endcan
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            退出
        </a>
    </div>
</li>
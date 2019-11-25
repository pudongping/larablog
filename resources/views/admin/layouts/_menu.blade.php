<!-- Sidebar -->
{{-- 侧边栏 --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Alex<sup>8023</sup></div>
    </a>

    <!-- Divider -->
    {{-- 分割线 --}}
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    {{-- 导航项目 - 仪表盘 --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>仪表盘</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - Pages Collapse Menu -->
    {{-- 左侧折叠导航栏 --}}
    @foreach($menusTree as $menu)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo{{ $menu['id'] }}" aria-expanded="true" aria-controls="collapseTwo{{ $menu['id'] }}">
            <i class="{{ $menu['icon'] }}"></i>
            <span>{{ $menu['name'] }}</span>
        </a>
        <div id="collapseTwo{{ $menu['id'] }}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">{{ $menu['description'] }}</h6>
                @isset($menu['children'])
                    @foreach($menu['children'] as $child)
                        <a class="collapse-item" href="{{ $child['link'] ? route($child['link']) : '' }}">{{ $child['name'] }}</a>
                    @endforeach
                @endisset
            </div>
        </div>
    </li>
    @endforeach


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

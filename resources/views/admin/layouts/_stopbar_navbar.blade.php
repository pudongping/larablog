<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    {{--<!-- Nav Item - Search Dropdown (Visible Only XS) -->--}}
    {{--@include('admin.layouts.stopbar-navbar._nav_item_search_dropdown')--}}

    {{--<!-- Nav Item - Alerts -->--}}
    {{--@include('admin.layouts.stopbar-navbar._nav_item_alerts')--}}

    {{--<!-- Nav Item - Messages -->--}}
    {{--@include('admin.layouts.stopbar-navbar._nav_item_messages')--}}

    {{-- 用户中心左边的竖线 --}}
    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    @include('admin.layouts.stopbar-navbar._suser_information')

</ul>

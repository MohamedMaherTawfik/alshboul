<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('user.dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/admin/imgs/logoFull.png') }}" alt="AdminLTE Logo" class="brand-image elevation-3"
            style="opacity: .8; width: 100px ; height: 50px">
        <span class="brand-text font-weight-light"> لوحة التحكم</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="pb-3 mt-3 mb-3 user-panel d-flex">
            <div class="image">
                <img src="{{ asset('assets/admin/dist/img/avatar5.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                @if (auth()->check())
                    <a href="#" class="d-block">{{ Auth::user()->username }}</a>
                @else
                    <a href="#" class="d-block"></a>
                @endif
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview {{ request()->is('user/request*') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ request()->is('user/request*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            إدارة طلباتي
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('user.request.index') }}"
                                class="nav-link {{ request()->is('user/request*') ? 'active' : '' }} ">
                                <i class="fas fa-shopping-cart nav-icon text-primary"></i>
                                <p> طلباتي</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item has-treeview {{ request()->is('user/chat*') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ request()->is('user/chat*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الدردشة
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.chat.with') }}"
                                class="nav-link {{ request()->is('user/chat*') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon text-warning"></i>
                                <p> التواصل مع الادارة</p>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

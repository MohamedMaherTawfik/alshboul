<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
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
                <li
                    class="nav-item has-treeview {{ request()->is('admin/about*') | request()->is('admin/move-bars*') | request()->is('admin/casetypes*') | request()->is('admin/social-links*') | request()->is('admin/sliders*') ? 'menu-open' : '' }} ">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/about*') | request()->is('admin/move-bars*') | request()->is('admin/casetypes*') | request()->is('admin/social-links*') | request()->is('admin/sliders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            أعدادات الموقع
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('move-bars.index') }}"
                                class="nav-link {{ request()->is('admin/move-bars*') ? 'active' : '' }}">
                                <i class="fas fa-running nav-icon text-warning"></i>
                                <p> الشريط المتحرك </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('sliders.index') }}"
                                class="nav-link {{ request()->is('admin/sliders*') ? 'active' : '' }}">
                                <i class="fas fa-images nav-icon text-warning"></i>
                                <p> السلايدرات </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('sociallinks.index') }}"
                                class="nav-link {{ request()->is('admin/social-links*') ? 'active' : '' }}">
                                <i class="fas fa-share-alt nav-icon text-warning"></i>
                                <p> روابط التواصل الاجتماعي </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('aboutus.index') }}"
                                class="nav-link {{ request()->is('admin/about*') ? 'active' : '' }}">
                                <i class="fas fa-info-circle nav-icon text-warning"></i>
                                <p> من نحن </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('casetypes.index') }}"
                                class="nav-link {{ request()->is('admin/casetypes*') ? 'active' : '' }}">
                                <i class="fas fa-balance-scale nav-icon text-warning"></i>
                                <p> انواع القضايا </p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->is('admin/careers*') | request()->is('admin/apply-careers*') ? 'menu-open' : '' }} ">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/careers*') | request()->is('admin/apply-careers*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            إدارة الوظائف
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('careers.index') }}"
                                class="nav-link {{ request()->is('admin/careers*') ? 'active' : '' }}">
                                <i class="fas fa-briefcase nav-icon text-warning"></i>
                                <p> الوظائف </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('apply-careers.all') }}"
                                class="nav-link {{ request()->is('admin/apply-careers*') ? 'active' : '' }}">
                                <i class="fas fa-user-check nav-icon text-warning"></i>
                                <p> متقدمي للوظائف </p>
                            </a>
                        </li>



                    </ul>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->is('admin/client*') | request()->is('admin/action*') | request()->is('admin/request*') ? 'menu-open' : '' }} ">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/client*') | request()->is('admin/action*') | request()->is('admin/request*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            إدارة الموكلين
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('client.index') }}"
                                class="nav-link {{ request()->is('admin/clients*') ? 'active' : '' }}">
                                <i class="fas fa-user nav-icon text-warning"></i>
                                <p> الموكلين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('client.indexDelete') }}"
                                class="nav-link {{ request()->is('admin/client/delete*') ? 'active' : '' }}">
                                <i class="fas fa-user nav-icon text-danger"></i>
                                <p> الموكلين المحذوفين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('request.index') }}"
                                class="nav-link {{ request()->is('admin/request*') ? 'active' : '' }} ">
                                <i class="fas fa-shopping-cart nav-icon text-primary"></i>
                                <p> طلبات الموكلين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('client.action') }}"
                                class="nav-link {{ request()->is('admin/action*') ? 'active' : '' }} ">
                                <i class="fa fa-tasks nav-icon text-success"></i>
                                <p> اجراءات الموكلين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('client.visit') }}" class="nav-link ">
                                <i class="fa fa-eye nav-icon text-info"></i>
                                <p> زيارات الموكلين</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/lawyer*') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ request()->is('admin/lawyer*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            إدارة المحامين
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('lawyer.index') }}"
                                class="nav-link {{ request()->is('admin/lawyers*') ? 'active' : '' }}">
                                <i class="fas fa-user-plus nav-icon text-warning"></i>
                                <p> المحامين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('lawyer.indexDelete') }}"
                                class="nav-link {{ request()->is('admin/lawyer/delete*') ? 'active' : '' }}">
                                <i class="fas fa-user-plus nav-icon text-danger"></i>
                                <p> المحامين المحذوفين</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/user*') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            إدارة المستخدمين
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}"
                                class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon text-warning"></i>
                                <p> المستخدمين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.indexDelete') }}"
                                class="nav-link {{ request()->is('admin/user/delete*') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon text-danger"></i>
                                <p> المستخدمين المحذوفين</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->is('admin/chat*') ? 'menu-open' : '' }} ">
                    <a href="#" class="nav-link {{ request()->is('admin/chat*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الدردشة
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('chat.with') }}"
                                class="nav-link {{ request()->is('admin/chat/admin*') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon text-warning"></i>
                                <p>دردشة الإدارة </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('chat.with1') }}"
                                class="nav-link {{ request()->is('admin/chat/law*') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon text-warning"></i>
                                <p>دردشة المحامين </p>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a href="{{ route('chat.with2') }}"
                                class="nav-link {{ request()->is('admin/chat/user*') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon text-warning"></i>
                                <p>دردشة المستخدمين </p>
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

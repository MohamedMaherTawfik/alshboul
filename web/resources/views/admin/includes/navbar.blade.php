<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('assets/admin/imgs/logoFull.png') }}" style="width: 100px; height: 50px; opacity: .8"
            alt="Logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu"
        aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav ml-auto">
            @if (auth()->check())
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ Auth::user()->username }}</a>
                </li>
            @endif

            <!-- إعدادات الموقع -->
            <!-- إعدادات الموقع -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/about*') || request()->is('admin/move-bars*') || request()->is('admin/casetypes*') || request()->is('admin/social-links*') || request()->is('admin/sliders*') ? 'active' : '' }}"
                    href="#" data-toggle="dropdown">
                    إعدادات الموقع
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('move-bars.index') }}">الشريط المتحرك</a>
                    <a class="dropdown-item" href="{{ route('sliders.index') }}">السلايدرات</a>
                    <a class="dropdown-item" href="{{ route('sociallinks.index') }}">روابط التواصل</a>
                    <a class="dropdown-item" href="{{ route('aboutus.index') }}">من نحن</a>
                    <a class="dropdown-item" href="{{ route('casetypes.index') }}">أنواع القضايا</a>
                </div>
            </li>

            <!-- إدارة المستخدمين -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/user*') || request()->is('admin/lawyer*') || request()->is('admin/client*') || request()->is('admin/request*') || request()->is('admin/action*') || request()->is('admin/visit*') ? 'active' : '' }}"
                    href="#" data-toggle="dropdown">
                    إدارة المستخدمين
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('user.index') }}">المستخدمين</a>
                    <a class="dropdown-item" href="{{ route('lawyer.index') }}">المحامين</a>
                    <a class="dropdown-item" href="{{ route('client.index') }}">الموكلين</a>
                    <a class="dropdown-item" href="{{ route('request.index') }}">طلبات الموكلين</a>
                    <a class="dropdown-item" href="{{ route('client.action') }}">إجراءات الموكلين</a>
                    <a class="dropdown-item" href="{{ route('client.visit') }}">زيارات الموكلين</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/executive-case*') | request()->is('admin/procedural-records*') ? 'active' : '' }}"
                    href="#" id="executiveCaseDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    إدارة القضايا التنفيذية
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="executiveCaseDropdown">
                    <a class="dropdown-item" href="{{ route('executive-case.index', 1) }}">القضايا التنفيدية
                        الفعالة</a>
                    <a class="dropdown-item" href="{{ route('executive-case.index', 2) }}">القضايا التنفيذية المنتهية
                    </a>
                    <a class="dropdown-item" href="{{ route('executive-case.index', 3) }}">القضايا التنفيذية
                        الموقوفة</a>
                    <a class="dropdown-item" href="{{ route('executive-case.index', 4) }}">القضايا التنفيذية
                        انابات</a>

                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/settlement*') ? 'active' : '' }}"
                    href="#" id="settlementDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    إدارة التسويات
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settlementDropdown">
                    @php
                        $types = \App\Models\SettlementType::all();
                    @endphp
                    @foreach ($types as $type)
                        <a class="dropdown-item" href="{{ route('settlement.index', ['type' => $type->id]) }}">
                            {{ $type->name_ar }}
                        </a>
                    @endforeach
                    <a class="dropdown-item" href="{{ route('settlement.index') }}">كل التسويات</a>
                    <a class="dropdown-item" href="{{ route('settlement.indexDelete') }}">التسويات المحذوفة</a>
                </div>
            </li>

            <!-- إدارة القضايا والاتفاقيات -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/agreement*') ? 'active' : '' }}"
                    href="#" data-toggle="dropdown">
                    الاتفاقيات </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('agreement.index') }}">الاتفاقيات</a>
                </div>
            </li>

            <!-- إدارة الوظائف -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/careers*') || request()->is('admin/apply-careers*') ? 'active' : '' }}"
                    href="#" data-toggle="dropdown">
                    الوظائف
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('careers.index') }}">الوظائف</a>
                    <a class="dropdown-item" href="{{ route('apply-careers.all') }}">متقدمي الوظائف</a>
                </div>
            </li>

            <!-- الدردشة -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/chat*') ? 'active' : '' }}" href="#"
                    data-toggle="dropdown">
                    الدردشة
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('chat.with') }}">دردشة الإدارة</a>
                    <a class="dropdown-item" href="{{ route('chat.with1') }}">دردشة المحامين</a>
                    <a class="dropdown-item" href="{{ route('chat.with2') }}">دردشة المستخدمين</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/*Delete*') ? 'active' : '' }}"
                    href="#" id="deletedItemsMenu" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    العناصر المحذوفة
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="deletedItemsMenu">
                    <a class="dropdown-item" href="{{ route('user.indexDelete') }}">المستخدمين</a>
                    <a class="dropdown-item" href="{{ route('lawyer.indexDelete') }}">المحامين</a>
                    <a class="dropdown-item" href="{{ route('client.indexDelete') }}">الموكلين </a>
                    <a class="dropdown-item" href="{{ route('agreement.indexDelete') }}">الاتفاقيات</a>
                    <a class="dropdown-item" href="{{ route('executive-case.indexDelete') }}">القضايا التنفيذية</a>
                    <a class="dropdown-item" href="{{ route('settlement.indexDelete') }}">التسويات </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/*archive*') ? 'active' : '' }}"
                    href="#" id="deletedItemsMenu" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    الأرشيف
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="deletedItemsMenu">
                    <a class="dropdown-item" href="{{ route('archive.index') }}">نظام الارشفه</a>
                    <a class="dropdown-item" href="{{ route('archive.reports') }}">تقارير الارشفه</a>
                    <a class="dropdown-item" href="{{ route('archive.main.create') }}"> اضافه قوائم رئيسيه</a>

                </div>
            </li>

            <!-- زر تسجيل الخروج -->
            <li class="nav-item">
                <a href="{{ route('admin.logout') }}" class="nav-link">خروج</a>
            </li>

        </ul>
    </div>
</nav>

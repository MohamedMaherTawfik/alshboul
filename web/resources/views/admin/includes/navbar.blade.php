@php
    use App\Models\CaseType;
    use App\Models\SettlementMain;
    use App\Models\excutiveCasesMain;
    use App\Models\MainNav;
    use App\Models\subNav;
    use App\Models\TransactionsMain;
    use App\Models\MainAgencies;

    $message = \App\Models\Message::where('receiver_id', Auth::id())->where('seen', '0')->count();
    $lawyerId = Auth::user()->id;
    $missionsCount = \App\Models\Missions::where('is_done', 0)
        ->where(function ($query) use ($lawyerId) {
            $query->where('first_lawyer_id', $lawyerId)->orWhere('second_lawyer_id', $lawyerId);
        })
        ->count();
    $cases = CaseType::where('is_active', 1)->get();
    $excutive = excutiveCasesMain::where('is_active', 1)->get();
    $settlements = SettlementMain::where('is_active', 1)->get();
    $transactions = TransactionsMain::where('is_active', 1)->get();
    $mains = MainNav::all();
    $subNavs = subNav::all();
    $agencies = MainAgencies::where('is_active', 1)->get();
@endphp
<style>
    /* تصغير حجم الخط والمسافات بين العناصر في النافبار */
    .navbar .nav-link,
    .navbar .dropdown-item {
        font-size: 14px !important;
        /* أصغر بحوالي 2px من الافتراضي */
        padding: 4px 8px !important;
        /* تقليل الحواف الداخلية */
    }

    /* تصغير الأيقونات والمسافات بينها */
    .navbar .fa {
        font-size: 14px !important;
    }

    /* تصغير شعار الموقع قليلاً */
    .navbar-brand img {
        width: 85px !important;
        height: 40px !important;
    }

    /* تقليل التباعد بين القوائم */
    .navbar-nav .nav-item {
        margin-left: 4px !important;
        margin-right: 4px !important;
    }

    /* تصغير القوائم المنسدلة */
    .dropdown-menu {
        font-size: 14px !important;
        min-width: 160px !important;
    }

    /* تصغير الأزرار الصغيرة مثل الإشعارات */
    .badge {
        font-size: 10px !important;
        padding: 2px 5px !important;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('assets/admin/imgs/logoFull.png') }}" style="width: 100px; height: 50px; opacity: .8"
            alt="Logo">

    </a>

    <!-- Notification Bell -->
    <div class="position-relative ml-3">
        <i class="fas fa-bell text-white fa-lg"></i>
        <a href='{{ route('show.notification') }}' class="badge badge-danger position-absolute"
            style="top: -5px; right: -10px; font-size: 12px;">
            {{ $message }}
        </a>
    </div>
    <div class="position-relative ml-3">
        <i class="fas fa-clipboard-list text-white fa-lg"></i>
        <a href="{{ route('me.missions.show') }}" class="badge badge-danger position-absolute"
            style="top: -5px; right: -10px; font-size: 12px;">
            {{ $missionsCount }}
        </a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu"
        aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav ml-auto">
            @if (Auth::check())
                <li class="nav-item">
                    <a class="nav-link" href="#">{{ Auth::user()->username }}</a>
                </li>
            @endif

            <!-- إعدادات الموقع -->
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
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
                    </div>
                </li>
            @endif

            {{-- اعدادات الادمن --}}
            @if (Auth::user()->role == 'superadmin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('admin/*setting*') ? 'active' : '' }}"
                        href="#" id="deletedItemsMenu" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        اعدادات الادمن
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="deletedItemsMenu">
                        <a class="dropdown-item" href="{{ route('casetypes.index') }}">اضافه نوع او حاله</a>
                        <a class="dropdown-item" href="{{ route('MainTypes.index') }}">اضافه عنوان رئيسي </a>
                        <a class="dropdown-item" href="{{ route('visitors.index') }}">اراء الزوار بالنسبه للموقع</a>
                        <hr>
                        <a class="dropdown-item" href="{{ route('archive.index') }}">تسجيلات دخول الموبايل</a>

                    </div>
                </li>
            @endif

            <!-- إدارة المستخدمين -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/user*') || request()->is('admin/lawyer*') || request()->is('admin/client*') || request()->is('admin/request*') || request()->is('admin/action*') || request()->is('admin/visit*') ? 'active' : '' }}"
                    href="#" data-toggle="dropdown">
                    إدارة المستخدمين
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                        <a class="dropdown-item" href="{{ route('user.index') }}">المستخدمين</a>
                        <a class="dropdown-item" href="{{ route('client.index') }}">الموكلين</a>
                    @endif
                    <a class="dropdown-item" href="{{ route('request.index') }}">طلبات الموكلين</a>
                    <a class="dropdown-item" href="{{ route('client.action.index') }}">إجراءات الموكلين</a>
                    <a class="dropdown-item" href="{{ route('client.visit') }}">زيارات الموكلين</a>
                </div>
            </li>


            {{-- القضايا --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/casetypes*') | request()->is('admin/cases*') ? 'active' : '' }}"
                    href="#" id="executiveCaseDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    جميع القضايا
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="executiveCaseDropdown">
                    @foreach ($cases as $case)
                        <a class="dropdown-item" href="{{ route('casetypes.show', $case) }}">
                            {{ $case->name }}</a>
                    @endforeach

                </div>
            </li>

            {{-- القضايا التنفيذيه --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/executive-case*') | request()->is('admin/procedural-records*') ? 'active' : '' }}"
                    href="#" id="executiveCaseDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    إدارة القضايا التنفيذية
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="executiveCaseDropdown">
                    @foreach ($excutive as $item)
                        <a class="dropdown-item" href="{{ route('executive-case.index', $item) }}">
                            {{ $item->name }}
                        </a>
                    @endforeach
                </div>
            </li>

            {{-- التسويات --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/settlement*') ? 'active' : '' }}"
                    href="#" id="settlementDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    إدارة التسويات
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settlementDropdown">
                    @foreach ($settlements as $type)
                        <a class="dropdown-item" href="{{ route('settlement.index', $type) }}">
                            {{ $type->name }}
                        </a>
                    @endforeach
                    <a class="dropdown-item" href="{{ route('settlement.all') }}">جميع التسويات</a>
                </div>
            </li>


            {{-- المعاملات --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/transactions*') ? 'active' : '' }}"
                    href="#" id="settlementDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    المعاملات
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settlementDropdown">
                    @foreach ($transactions as $type)
                        <a class="dropdown-item" href="{{ route('transactions.all', $type) }}">
                            {{ $type->name }}
                        </a>
                    @endforeach
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/agencies*') ? 'active' : '' }}"
                    href="#" id="settlementDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    وكالات واتفاقيات
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settlementDropdown">
                    @foreach ($agencies as $type)
                        <a class="dropdown-item" href="{{ route('agencies.index', $type) }}">
                            {{ $type->name }}
                        </a>
                    @endforeach
                </div>
            </li>

            {{-- الجديد --}}
            @foreach ($mains as $info)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('admin/' . $info->title . '/*') ? 'active' : '' }}"
                        href="#" id="settlementDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ $info->title }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settlementDropdown">
                        @foreach ($subNavs as $item)
                            @if ($item->main_nav_id == $info->id)
                                <a class="dropdown-item"
                                    href="{{ route('subNav.index', $item) }}">{{ $item->name }}</a>
                            @endif
                        @endforeach
                    </div>
                </li>
            @endforeach

            {{-- الوظائف --}}
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
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
            @endif


            <!-- الدردشة -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/chat*') ? 'active' : '' }}" href="#"
                    data-toggle="dropdown">
                    الدردشة
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('chat.with') }}">دردشة الإدارة</a>
                    <a class="dropdown-item" href="{{ route('chat.with1') }}">دردشة المحامين</a>
                    <a class="dropdown-item" href="{{ route('chat.with2') }}">دردشة الموكلين</a>
                </div>
            </li>

            <!-- البحث -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/search*') ? 'active' : '' }}"
                    href="#" data-toggle="dropdown">
                    البحث
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('cases.search') }}" class="dropdown-item">بحث تاريخ الجلسات </a>
                    <a href="{{ route('duration.search') }}" class="dropdown-item">بحث تاريخ المدد </a>
                    <a href="{{ route('note.search') }}" class="dropdown-item">بحث تاريخ المذكرات </a>
                    <a href="{{ route('mission.finished.search') }}" class="dropdown-item">بحث المهمات المنجزه </a>
                    <a href="{{ route('mission.unfinished.search') }}" class="dropdown-item">بحث المهمات الغير منجزه
                    </a>
                    <hr>
                    <a href="{{ route('public.search.index') }}" class="dropdown-item">البحث العام</a>
                    <a href="{{ route('report.index') }}" class="dropdown-item">تقارير البحث</a>
                </div>
            </li>

            {{-- المحذوفات --}}
            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('admin/*Delete*') ? 'active' : '' }}"
                        href="#" id="deletedItemsMenu" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        العناصر المحذوفة
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="deletedItemsMenu">
                        <a class="dropdown-item" href="{{ route('user.indexDelete') }}">المستخدمين</a>
                        <a class="dropdown-item" href="{{ route('lawyer.indexDelete') }}">المحامين</a>
                        <a class="dropdown-item" href="{{ route('client.indexDelete') }}">الموكلين </a>
                        <a class="dropdown-item" href="{{ route('agreement.indexDelete') }}">الاتفاقيات</a>
                        <a class="dropdown-item" href="{{ route('executive-case.indexDelete') }}">القضايا
                            التنفيذية</a>
                        <a class="dropdown-item" href="{{ route('cases.indexDelete') }}">القضايا</a>
                        <a class="dropdown-item" href="{{ route('settlement.indexDelete') }}">التسويات </a>
                        <a class="dropdown-item" href="{{ route('archive.indexDelete') }}">الارشيف </a>
                        <a class="dropdown-item" href="{{ route('mission.indexDelete') }}">المهام </a>
                    </div>
                </li>
            @endif

            {{-- المهام --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->is('admin/*Mission*') ? 'active' : '' }}"
                    href="#" id="deletedItemsMenu" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    المهام
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="deletedItemsMenu">
                    <a class="dropdown-item" href="{{ route('mission.add') }}">اضافه مهمه</a>
                    <a class="dropdown-item" href="{{ route('mission.finished') }}">المهام المنجزه</a>
                    <a class="dropdown-item" href="{{ route('mission.unfinished') }}">المهام الغير منجزه </a>

                    <hr style="font-weight: bold">

                </div>
            </li>

            {{-- الارشيف --}}
            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('admin/*archive*') ? 'active' : '' }}"
                        href="#" id="deletedItemsMenu" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        الأرشيف
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="deletedItemsMenu">
                        <a class="dropdown-item" href="{{ route('archive.index') }}">نظام الارشفه</a>
                        <a class="dropdown-item" href="{{ route('archive.reports') }}">تقارير الارشفه</a>
                        <a class="dropdown-item" href="{{ route('archive.main.create') }}"> اضافه قوائم رئيسيه</a>
                    </div>
                </li>
            @endif

            <!-- زر تسجيل الخروج -->
            <li class="nav-item">
                <a href="{{ route('admin.logout') }}" class="nav-link">خروج</a>
            </li>

        </ul>
    </div>
</nav>

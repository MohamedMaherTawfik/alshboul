@extends('layouts.admin')
@section('title', 'الأرشيف')
@section('main_title_content', 'قائمة الأرشيف')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('archive.reports') }}">الأرشيف</a>
@endsection

@section('content')
    <div class="container-fluid">

        <form action="{{ route('archive.reports.search') }}" method="GET" class="row g-2 align-items-center mb-4">

            <!-- من تاريخ -->
            <div class="col-auto d-flex align-items-center">
                <label for="from_date" class="me-2 mb-0 fw-bold text-dark" style="font-size: 0.85rem;">من: </label>
                <input type="date" name="from_date" id="from_date" class="form-control form-control-sm"
                    value="{{ request('from_date') }}">
            </div>

            <!-- إلى تاريخ -->
            <div class="col-auto d-flex align-items-center">
                <label for="to_date" class="me-2 mb-0 fw-bold text-dark" style="font-size: 0.85rem;">إلى: </label>
                <input type="date" name="to_date" id="to_date" class="form-control form-control-sm"
                    value="{{ request('to_date') }}">
            </div>

            <!-- القسم الرئيسي -->
            <div class="col-auto d-flex align-items-center">
                <label for="main_menu_id" class="me-2 mb-0 fw-bold text-dark" style="font-size: 0.85rem;">رئيسي: </label>
                <select name="main_menu_id" id="main_menu_id" class="form-select form-select-sm">
                    <option value="">-- اختر --</option>
                    @foreach ($archiveMainMenues as $menu)
                        <option value="{{ $menu->id }}" {{ request('main_menu_id') == $menu->id ? 'selected' : '' }}>
                            {{ $menu->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- القسم الفرعي -->
            <div class="col-auto d-flex align-items-center">
                <label for="sub_menu_id" class="me-2 mb-0 fw-bold text-dark" style="font-size: 0.85rem;">فرعي: </label>
                <select name="sub_menu_id" id="sub_menu_id" class="form-select form-select-sm">
                    <option value="">-- اختر --</option>
                    @foreach ($archivesSubMenues as $submenu)
                        <option value="{{ $submenu->id }}" data-parent="{{ $submenu->main_menu_id }}"
                            {{ request('sub_menu_id') == $submenu->id ? 'selected' : '' }}>
                            {{ $submenu->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- زر البحث -->
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary">بحث</button>
                <a href="{{ route('archive.reports') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
            </div>
        </form>

        @if (route('archive.reports.search') == request()->url())
            <!-- الجدول -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="archive-table">
                    <thead class="table-dark">
                        <tr>
                            <th>رقم الوثيقه</th>
                            <th>اسم المُنشئ</th>
                            <th>القائمة الرئيسية</th>
                            <th>القائمة الفرعية</th>
                            <th>اسم الموكل</th>
                            <th>اطراف اخري</th>
                            <th>الملف</th>
                            <th>الوصف الدقيق للمستند</th>
                            <th>تاريخ الإنشاء</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($archives->count() > 0)
                            @foreach ($archives as $archive)
                                <tr data-sub-menu-id="{{ $archive->archivesSubMenues->id ?? '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $archive->user->name ?? 'غير معروف' }}</td>
                                    <td>{{ $archive->archivesSubMenues->archivesMainMenues->name ?? 'لا يوجد' }}</td>
                                    <td>{{ $archive->archivesSubMenues->name ?? 'لا يوجد' }}</td>
                                    <td>{{ $archive->client->name }}</td>
                                    <td>{{ Str::limit($archive->another_names ?? 'لا يوجد', 50, '...') }}</td>
                                    <td>
                                        @if ($archive->file)
                                            <a href="{{ asset('storage/' . $archive->file) }}" target="_blank"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-file"></i> عرض الملف
                                            </a>
                                        @else
                                            <span class="text-muted">لا يوجد ملف</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($archive->notes ?? 'لا يوجد', 50, '...') }}</td>

                                    <td>{{ $archive->time }}</td>
                                    <td>
                                        <!-- زر تعديل -->
                                        <a href="{{ route('archive.edit', $archive) }}" class="text-primary ml-2 me-2">
                                            <i class="fas fa-edit fa-lg"></i>
                                        </a>

                                        @if (Auth::user()->role == 'superadmin')
                                            <!-- زر حذف -->
                                            <!-- زرار الحذف -->
                                            <button type="button" class="btn btn-link text-danger p-0 m-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmDeleteModal{{ $archive->id }}">
                                                <i class="fas fa-trash-alt fa-lg"></i>
                                            </button>

                                            <!-- مودال التأكيد -->
                                            <div class="modal fade" id="confirmDeleteModal{{ $archive->id }}"
                                                tabindex="-1" aria-labelledby="confirmDeleteModalLabel{{ $archive->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('archive.destroy', $archive) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="confirmDeleteModalLabel{{ $archive->id }}">تأكيد
                                                                    الحذف
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>من فضلك أدخل بريدك الإلكتروني وكلمة المرور للتأكيد.</p>
                                                                <div class="mb-3">
                                                                    <label for="text" class="form-label">البريد
                                                                        الإلكتروني</label>
                                                                    <input type="text" name="email"
                                                                        class="form-control" required />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="password" class="form-label">كلمة
                                                                        المرور</label>
                                                                    <input type="password" name="password"
                                                                        class="form-control" required />
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">إلغاء</button>
                                                                <button type="submit" class="btn btn-danger">تأكيد
                                                                    الحذف</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="text-center text-muted">لا توجد بيانات في الأرشيف.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        @else
            {{-- قم بالبحث اولا --}}
            <div class="alert alert-info text-center">قم بالبحث اولا</div>
        @endif
    </div>
@endsection



<script>
    document.addEventListener("DOMContentLoaded", function() {
        let mainMenu = document.getElementById("main_menu_id");
        let subMenu = document.getElementById("sub_menu_id");
        let allOptions = Array.from(subMenu.options);

        mainMenu.addEventListener("change", function() {
            let selectedMain = this.value;

            // رجع الاختيارات الأصلية
            subMenu.innerHTML = "";

            // أضف الاختيار الافتراضي
            subMenu.appendChild(new Option("-- اختر من القائمة --", "", true, true));
            subMenu.options[0].disabled = true;

            // فلترة الفرعيات تبع الرئيسي
            allOptions.forEach(opt => {
                if (opt.getAttribute("data-parent") === selectedMain) {
                    subMenu.appendChild(opt);
                }
            });

            subMenu.disabled = false;
        });
    });
</script>

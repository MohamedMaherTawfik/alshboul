@extends('layouts.admin')
@section('title', 'الأرشيف')
@section('main_title_content', 'قائمة الأرشيف')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('archive.index') }}">الأرشيف</a>
@endsection
@section('content')
    <div class="container-fluid">
        <!-- زر الإضافة و زر عرض الكل في سطر واحد -->
        <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
            <!-- زر dropdown للإجراءات -->
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle d-flex align-items-center"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-plus ml-2 me-2"></i>
                    إجراءات الأرشيف
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <!-- إضافة قائمة رئيسية -->
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('archive.main.create') }}">
                            <i class="fas fa-folder-plus ml-2 me-2 text-primary"></i>
                            إضافة قائمة رئيسية
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider m-0">
                    </li>
                    <!-- إضافة ملف إلى الأرشيف -->
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('archive.create') }}">
                            <i class="fas fa-file-upload m1- me-2 text-success"></i>
                            إضافة ملف إلى الأرشيف
                        </a>
                    </li>
                </ul>
            </div>

            <!-- زر عرض الكل -->
            <button class="btn btn-outline-secondary mr-2 d-flex align-items-center filter-btn">
                <i class="fas fa-list ml-2 me-2"></i>
                عرض الكل
            </button>
        </div>

        <!-- قائمة الفلاتر (القوائم الفرعية كأزرار فلترة) -->
        <div class="mb-4">
            <ul class="nav nav-pills flex-column flex-md-row">
                @foreach ($mains as $main)
                    <li class="nav-item dropdown mx-1 mb-2 mb-md-0">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button"
                            id="dropdown{{ $main->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $main->name }}
                        </button>
                        <ul class="dropdown-menu shadow" aria-labelledby="dropdown{{ $main->id }}">
                            @if ($main->archivesSubMenues && $main->archivesSubMenues->isNotEmpty())
                                @foreach ($main->archivesSubMenues as $sub)
                                    <li>
                                        <button class="dropdown-item filter-btn d-flex align-items-center"
                                            data-sub-menu="{{ $sub->id }}">
                                            <i class="fas fa-filter me-2 text-primary"></i>
                                            فلترة حسب: {{ $sub->name }}
                                        </button>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider m-0">
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <span class="dropdown-item text-muted d-flex align-items-center">
                                        <i class="fas fa-folder-open me-2"></i>
                                        لا توجد قوائم فرعية
                                    </span>
                                </li>
                                <li>
                                    <hr class="dropdown-divider m-0">
                                </li>
                            @endif

                            <!-- زر "إضافة قائمة فرعية" (يظهر في كل dropdown سواء كان فارغ أو لا) -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center text-success fw-bold"
                                    href="{{ route('archive.subMain.create', $main->id) }}">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    إضافة قائمة فرعية جديدة
                                </a>
                            </li>
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- الجدول -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center" id="archive-table">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>اسم المُنشئ</th>
                        <th>القائمة الرئيسية</th>
                        <th>القائمة الفرعية</th>
                        <th>الاسم</th>
                        <th>الملف</th>
                        <th>الوصف</th>
                        <th>ملاحظات</th>
                        <th>تاريخ الإنشاء</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($archives->count() > 0)
                        @foreach ($archives as $archive)
                            <tr data-sub-menu-id="{{ $archive->archivesSubMenues->id ?? '' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $archive->user->name ?? 'غير معروف' }}</td>
                                <td>{{ $archive->mainCategory->name ?? 'لا يوجد' }}</td>
                                <td>{{ $archive->archivesSubMenues->name ?? 'لا يوجد' }}</td>
                                <td>{{ $archive->name }}</td>
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
                                <td>{{ Str::limit($archive->description, 50, '...') }}</td>
                                <td>{{ Str::limit($archive->notes, 50, '...') }}</td>
                                <td>{{ $archive->created_at->format('Y-m-d | H:i') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center text-muted">لا توجد بيانات في الأرشيف.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript للفلترة -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const tableRows = document.querySelectorAll('#archive-table tbody tr');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const subMenuId = this.getAttribute('data-sub-menu'); // فارغ = عرض الكل

                    tableRows.forEach(row => {
                        const rowSubMenuId = row.getAttribute('data-sub-menu-id');

                        if (subMenuId === '' || rowSubMenuId === subMenuId) {
                            row.style.display = ''; // اعرض
                        } else {
                            row.style.display = 'none'; // اخفِ
                        }
                    });
                });
            });
        });
    </script>
@endsection

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

        <!-- خانات البحث -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <input type="text" id="searchMainMenu" class="form-control" placeholder="بحث بالقائمة الرئيسية">
            </div>
            <div class="col-md-3">
                <input type="text" id="searchSubMenu" class="form-control" placeholder="بحث بالقائمة الفرعية">
            </div>
            <div class="col-md-3">
                <input type="text" id="searchClient" class="form-control" placeholder="بحث باسم الموكل">
            </div>
            <div class="col-md-3">
                <input type="text" id="searchAnother" class="form-control" placeholder="بحث بأطراف أخرى">
            </div>
        </div>
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
                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $archive->id }}">
                                            <i class="fas fa-trash-alt fa-lg"></i>
                                        </button>

                                        <!-- مودال التأكيد -->
                                        <div class="modal fade" id="confirmDeleteModal{{ $archive->id }}" tabindex="-1"
                                            aria-labelledby="confirmDeleteModalLabel{{ $archive->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('archive.destroy', $archive) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="confirmDeleteModalLabel{{ $archive->id }}">تأكيد الحذف
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="إغلاق"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>من فضلك أدخل بريدك الإلكتروني وكلمة المرور للتأكيد.</p>
                                                            <div class="mb-3">
                                                                <label for="text" class="form-label">البريد
                                                                    الإلكتروني</label>
                                                                <input type="text" name="email" class="form-control"
                                                                    required />
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
    </div>


@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchMainMenu = document.getElementById("searchMainMenu");
        const searchSubMenu = document.getElementById("searchSubMenu");
        const searchClient = document.getElementById("searchClient");
        const searchAnother = document.getElementById("searchAnother");

        const table = document.getElementById("archive-table");
        const rows = table.getElementsByTagName("tr");

        function filterTable() {
            const mainMenuValue = searchMainMenu.value.toLowerCase();
            const subMenuValue = searchSubMenu.value.toLowerCase();
            const clientValue = searchClient.value.toLowerCase();
            const anotherValue = searchAnother.value.toLowerCase();

            for (let i = 1; i < rows.length; i++) { // نبدأ من 1 عشان نتخطى الـ header
                const cells = rows[i].getElementsByTagName("td");
                if (cells.length > 0) {
                    const mainMenu = cells[2].textContent.toLowerCase(); // القائمة الرئيسية
                    const subMenu = cells[3].textContent.toLowerCase(); // القائمة الفرعية
                    const client = cells[4].textContent.toLowerCase(); // اسم الموكل
                    const another = cells[5].textContent.toLowerCase(); // اطراف اخرى

                    if (
                        mainMenu.includes(mainMenuValue) &&
                        subMenu.includes(subMenuValue) &&
                        client.includes(clientValue) &&
                        another.includes(anotherValue)
                    ) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        }

        searchMainMenu.addEventListener("keyup", filterTable);
        searchSubMenu.addEventListener("keyup", filterTable);
        searchClient.addEventListener("keyup", filterTable);
        searchAnother.addEventListener("keyup", filterTable);
    });
</script>

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

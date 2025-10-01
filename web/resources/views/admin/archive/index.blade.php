@extends('layouts.admin')
@section('title', 'الأرشيف')
@section('main_title_content', 'قائمة الأرشيف')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('archive.index') }}">الأرشيف</a>
@endsection

<style>
    /* تكبير حجم القوائم الرئيسية */
    .main-menu-btn {
        font-size: 25px !important;
        padding: 0.75rem 1.5rem !important;
        font-weight: bold;
        border: none;
        outline: none;
        transition: all 0.3s ease;
    }

    .main-menu-btn:hover {
        filter: brightness(1.1);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    /* تصميم الـ Dropdown ليكون Full Width */
    .submenu-dropdown {
        width: 100vw !important;
        max-width: none !important;
        left: 0 !important;
        right: 0 !important;
        top: 100% !important;
        margin: 0 !important;
        border: none;
        border-radius: 0;
        position: absolute;
        z-index: 1000;
        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(4px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.2s ease;
    }

    .submenu-dropdown.show {
        opacity: 1;
        transform: translateY(0);
    }

    /* حجم العناصر داخل الـ Dropdown */
    .dropdown-item {
        font-size: 25px !important;
        padding: 0.75rem 2rem !important;
        border-bottom: 1px solid #eee;
    }

    .dropdown-item:last-child {
        border-bottom: none;
    }

    /* تحسين الـ divider */
    .dropdown-divider {
        border-top: 1px solid #ddd;
        margin: 0 !important;
    }

    /* تحسين العرض على الموبايل */
    @media (max-width: 768px) {
        .main-menu-btn {
            font-size: 1.2rem !important;
            padding: 0.6rem 1rem !important;
        }

        .submenu-dropdown {
            width: 100vw !important;
            left: 0 !important;
            right: 0 !important;
            margin: 0 !important;
        }

        .dropdown-item {
            font-size: 1rem !important;
            padding: 0.6rem 1.5rem !important;
        }
    }
</style>
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
                    <li>
                        <a class="dropdown-item d-flex align-items-center text-primary fw-bold" href="#"
                            data-bs-toggle="modal" data-bs-target="#createMainModal">
                            <i class="fas fa-folder-plus me-2"></i>
                            إضافة قائمة رئيسية
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider m-0">
                    </li>
                    <!-- إضافة ملف إلى الأرشيف -->
                    <li>
                        <a class="dropdown-item d-flex align-items-center text-success fw-bold" href="#"
                            data-bs-toggle="modal" data-bs-target="#addArchiveModal">
                            <i class="fas fa-file-upload me-2"></i>
                            إضافة ملف إلى الأرشيف
                        </a>
                    </li>
                </ul>
            </div>

            <!-- زر عرض الكل -->
            <a href="{{ route('archive.index') }}"
                class="btn btn-outline-secondary mr-2 d-flex align-items-center filter-btn">
                <i class="fas fa-list ml-2 me-2"></i>
                عرض الكل
            </a>
        </div>

        <!-- قائمة الفلاتر (القوائم الفرعية كأزرار فلترة) -->
        <div class="mb-4 main-menu-container">
            <ul class="nav nav-pills flex-column flex-md-row">
                @foreach ($mains as $main)
                    @php
                        $colors = [
                            'primary',
                            'secondary',
                            'success',
                            'danger',
                            'warning',
                            'info',
                            'dark',
                            'purple',
                            'pink',
                            'teal',
                            'cyan',
                            'orange',
                            'indigo',
                            'lime',
                            'blue',
                        ];
                        $color = $colors[$main->id % count($colors)];
                    @endphp

                    <li class="nav-item dropdown mx-1 mb-2 mb-md-0">
                        <!-- زر القائمة الرئيسية -->
                        <button class="btn btn-{{ $color }} main-menu-btn py-3 px-4" type="button"
                            id="dropdown{{ $main->id }}" aria-expanded="false"
                            style="font-size: 25px; border: none; outline: none;">
                            {{ $main->name }}
                        </button>

                        <!-- القائمة المنسدلة (Dropdown) -->
                        <ul class="dropdown-menu shadow submenu-dropdown" id="dropdown-menu-{{ $main->id }}"
                            style="
                        width: 100vw;
                        max-width: none;
                        left: 0;
                        right: 0;
                        margin: 0;
                        border: none;
                        border-radius: 0;
                        position: absolute;
                        top: 100%;
                        z-index: 1000;
                        display: none;
                        background: rgba(255, 255, 255, 0.97);
                        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
                        backdrop-filter: blur(4px);
                        overflow: hidden;
                    "
                            aria-labelledby="dropdown{{ $main->id }}">

                            @if ($main->archivesSubMenues && $main->archivesSubMenues->isNotEmpty())
                                @foreach ($main->archivesSubMenues as $sub)
                                    <li>
                                        <button class="dropdown-item filter-btn d-flex align-items-center fs-6 py-2 px-4"
                                            data-sub-menu="{{ $sub->id }}">
                                            <i class="fas fa-folder me-2 text-{{ $color }}"></i>
                                            <span style="font-size: 25px">{{ $sub->name }}</span>
                                        </button>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider m-0">
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <span class="dropdown-item text-muted d-flex align-items-center fs-6 py-2 px-4">
                                        <i class="fas fa-folder-open me-2"></i>
                                        لا توجد قوائم فرعية
                                    </span>
                                </li>
                                <li>
                                    <hr class="dropdown-divider m-0">
                                </li>
                            @endif

                            <!-- زر الإضافة -->
                            <li>
                                <a class="dropdown-item d-flex align-items-center text-success fw-bold small px-2 py-1"
                                    href="#" data-bs-toggle="modal" data-bs-target="#createSubMainModal"
                                    data-main-id="{{ $main->id }}" data-user-id="{{ auth()->id() }}"
                                    data-next-number="{{ $missingNumbers[$main->id] }}">
                                    <i class="fas fa-plus-circle me-1"></i>
                                    إضافة قائمة فرعية
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
                                <td>{{ $archive->file_number }}</td>
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
                                    @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin')
                                        <a href="{{ route('archive.edit', $archive) }}" class="text-primary ml-2 me-2">
                                            <i class="fas fa-edit fa-lg"></i>
                                        </a>
                                    @endif
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

    <!-- Modal: إضافة أرشيف جديد -->
    <!-- Modal: إضافة أرشيف جديد -->
    <div class="modal fade" id="addArchiveModal" tabindex="-1" aria-labelledby="addArchiveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addArchiveModalLabel">
                        <i class="fas fa-file-upload me-2"></i>
                        إضافة أرشيف جديد
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('archive.store') }}" method="POST" enctype="multipart/form-data"
                        id="archiveForm">
                        @csrf

                        <div class="row g-3">

                            <!-- اسم المشترك (Autocomplete) -->
                            <div class="col-md-6">
                                <div class="mb-3 position-relative">
                                    <label for="client_name" class="form-label fw-bold text-dark">
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        اسم المشترك <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="client_name"
                                        class="form-control border-2 border-primary rounded-4 py-2 @error('client_id') is-invalid @enderror"
                                        placeholder="اكتب اسم المشترك" autocomplete="off" required>
                                    <input type="hidden" name="client_id" id="client_id">
                                    <!-- الاقتراحات -->
                                    <div id="client_suggestions" class="list-group position-absolute w-100"
                                        style="z-index: 1000; max-height: 200px; overflow-y: auto; display: none;">
                                    </div>
                                    @error('client_id')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- أطراف أخرى -->
                            <div class="col-md-6">
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="another_names" class="form-label fw-bold text-dark me-2">
                                        <i class="fas fa-users me-1 text-primary"></i>
                                        أطراف أخرى
                                    </label>
                                    <input type="text" name="another_names" id="another_names"
                                        class="form-control border-2 border-primary rounded-4 me-1 py-1 px-2 w-auto flex-shrink-1 @error('another_names') is-invalid @enderror"
                                        value="{{ old('another_names') }}" placeholder="اكتب هنا" required
                                        style="font-size: 0.9rem; min-width: 150px; width: auto;">
                                    <span class="text-danger ms-1">*</span>
                                </div>
                                @error('another_names')
                                    <div class="invalid-feedback d-block mt-1 ms-4" style="font-size: 0.8rem;">
                                        {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- القائمة الرئيسية -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="main_menu_id" class="form-label fw-bold text-dark">
                                        <i class="fas fa-folder me-2 text-primary"></i>
                                        قسم الرئيسي <span class="text-danger">*</span>
                                    </label>
                                    <select name="main_menu_id" id="main_menu_id"
                                        class="form-select border-2 border-primary rounded-4 py-2 @error('main_menu_id') is-invalid @enderror"
                                        required>
                                        <option value="" disabled selected>-- اختر من القائمة --</option>
                                        @foreach ($mains as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('main_menu_id')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- التاريخ -->
                            <div class="col-md-6">
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="time" class="form-label fw-bold text-dark me-2 ml-2">
                                        <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                        اختر التاريخ
                                    </label>
                                    <input type="date" name="time" id="time"
                                        class="form-control border-2 border-primary rounded-4 py-1 px-2 w-auto flex-shrink-1"
                                        required style="font-size: 0.9rem; width: 140px;">
                                    <span class="text-danger ms-1">*</span>
                                </div>
                            </div>

                            <!-- القائمة الفرعية -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sub_menu_id" class="form-label fw-bold text-dark">
                                        <i class="fas fa-list me-2 text-primary"></i>
                                        قسم الفرعي <span class="text-danger">*</span>
                                    </label>
                                    <select name="sub_menu_id" id="sub_menu_id"
                                        class="form-select border-2 border-primary rounded-4 py-2 @error('sub_menu_id') is-invalid @enderror"
                                        required>
                                        <option value="" disabled selected>-- اختر من القائمة --</option>
                                        @foreach ($subs as $submenu)
                                            <option value="{{ $submenu->id }}"
                                                data-parent="{{ $submenu->main_menu_id }}">
                                                {{ $submenu->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sub_menu_id')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- رفع الملف -->
                            <div class="col-md-6">
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="file" class="form-label fw-bold text-dark me-2">
                                        <i class="fas fa-upload me-1 text-primary"></i>
                                        رفع الملف
                                    </label>
                                    <input type="file" name="file" id="file"
                                        class="form-control border-2 border-primary rounded-4 py-1 px-2 w-auto flex-shrink-1"
                                        required style="font-size: 0.9rem; width: 140px;">
                                    <span class="text-danger ms-1">*</span>
                                </div>
                                @error('file')
                                    <div class="invalid-feedback d-block mt-1 ms-4" style="font-size: 0.8rem;">
                                        {{ $message }}</div>
                                @enderror
                            </div>

                            <!-- الملاحظة -->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">الوصف الدقيق للمستند</label>
                                    <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror"
                                        placeholder="أدخل أي ملاحظات إضافية">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- حقل مخفي: user_id -->
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> إلغاء
                    </button>
                    <button type="submit" form="archiveForm" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Autocomplete Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const clientInput = document.getElementById("client_name");
            const clientHidden = document.getElementById("client_id");
            const suggestionsBox = document.getElementById("client_suggestions");

            const clients = @json($clients);

            clientInput.addEventListener("input", function() {
                const query = this.value.toLowerCase();
                suggestionsBox.innerHTML = "";
                clientHidden.value = "";

                if (query.length < 1) {
                    suggestionsBox.style.display = "none";
                    return;
                }

                let filtered = clients.filter(client => client.name.toLowerCase().includes(query));

                if (filtered.length === 0) {
                    suggestionsBox.style.display = "none";
                    return;
                }

                filtered.forEach(client => {
                    let item = document.createElement("button");
                    item.type = "button";
                    item.className = "list-group-item list-group-item-action";
                    item.textContent = client.name;
                    item.onclick = function() {
                        clientInput.value = client.name;
                        clientHidden.value = client.id;
                        suggestionsBox.style.display = "none";
                    };
                    suggestionsBox.appendChild(item);
                });

                suggestionsBox.style.display = "block";
            });

            document.addEventListener("click", function(e) {
                if (!clientInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.style.display = "none";
                }
            });
        });
    </script>


    <!-- Modal لإضافة قائمة رئيسية -->
    <div class="modal fade" id="createMainModal" tabindex="-1" aria-labelledby="createMainModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMainModalLabel">إضافة قائمة رئيسية جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('archive.main.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- حقل مخفي للـ user_id -->
                        <input type="hidden" name="user_id" id="main_user_id_input">

                        <div class="mb-3">
                            <label for="main_name" class="form-label">اسم القائمة الرئيسية</label>
                            <input type="text" class="form-control" id="main_name" name="name"
                                placeholder="أدخل الاسم" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal وحيد لكل الصفحة -->
    <div class="modal fade" id="createSubMainModal" tabindex="-1" aria-labelledby="createSubMainModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSubMainModalLabel">إضافة قائمة فرعية جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('archive.subMain.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- الحقول المخفية -->
                        <input type="hidden" name="main_id" id="main_id_input">
                        <input type="hidden" name="user_id" id="user_id_input">

                        <div class="mb-3">
                            <label for="name" class="form-label">اسم القائمة الفرعية</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="أدخل الاسم" required>
                        </div>

                        <div class="mb-3">
                            <label for="document_number" class="form-label">رقم المستند</label>
                            <input type="text" class="form-control" id="document_number" name="document_number"
                                placeholder="ادخل رقم المستند" readonly>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-success">حفظ</button>
                    </div>
                </form>
            </div>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const subMainModal = document.getElementById('createSubMainModal');
        subMainModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const mainId = button.getAttribute('data-main-id');
            const userId = button.getAttribute('data-user-id');
            const nextNumber = button.getAttribute('data-next-number');

            // نضيف القيم في الفورم
            document.getElementById('main_id_input').value = mainId;
            document.getElementById('user_id_input').value = userId;
            document.getElementById('document_number').value = nextNumber;
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var createMainModal = document.getElementById('createMainModal');

        // لما يفتح المودال
        createMainModal.addEventListener('show.bs.modal', function() {
                // جيب الـ user_id من الـ data أو من الصفحة (ممكن تخليه في متغير)
                @auth
                var userId = "{{ auth()->id() }}";
                createMainModal.querySelector('#main_user_id_input').value = userId;
            @endauth
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuButtons = document.querySelectorAll('.main-menu-btn');
        let openDropdown = null;

        // عند المرور على الزر
        menuButtons.forEach(button => {
            const buttonId = button.id;
            const dropdownMenu = document.getElementById(
                `dropdown-menu-${buttonId.replace('dropdown', '')}`);

            // فتح بالـ hover
            button.addEventListener('mouseenter', function() {
                // أغلق أي dropdown مفتوح
                if (openDropdown && openDropdown !== dropdownMenu) {
                    openDropdown.classList.remove('show');
                    openDropdown.style.display = 'none';
                }

                dropdownMenu.style.display = 'block';
                setTimeout(() => {
                    dropdownMenu.classList.add('show');
                }, 10);

                openDropdown = dropdownMenu;
            });

            // منع الإغلاق عند الدخول للقائمة
            dropdownMenu.addEventListener('mouseenter', function() {
                openDropdown = dropdownMenu;
            });
        });

        // إغلاق القائمة عند النقر في أي مكان تاني
        document.addEventListener('click', function(e) {
            if (openDropdown) {
                // لو الضغط ما كانش على الزر ولا على القائمة → اغلق
                const isClickOnButton = e.target.closest('.main-menu-btn');
                const isClickOnDropdown = e.target.closest('.submenu-dropdown');

                if (!isClickOnButton && !isClickOnDropdown) {
                    openDropdown.classList.remove('show');
                    openDropdown.style.display = 'none';
                    openDropdown = null;
                }
            }
        });

        // منع الإغلاق عند الضغط على عنصر في القائمة
        document.querySelectorAll('.submenu-dropdown').forEach(menu => {
            menu.addEventListener('click', function(e) {
                e.stopPropagation(); // مهم
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const mainMenu = document.getElementById("main_menu_id");
        const subMenu = document.getElementById("sub_menu_id");
        const allSubOptions = Array.from(subMenu.querySelectorAll("option[data-parent]"));

        mainMenu.addEventListener("change", function() {
            const selectedMain = this.value;

            // نظف الخيارات الفرعية
            subMenu.innerHTML = "";
            subMenu.appendChild(new Option("-- اختر من القائمة --", "", true, true));
            subMenu.options[0].disabled = true;

            // أضف الخيارات المناسبة
            allSubOptions.forEach(opt => {
                if (opt.getAttribute("data-parent") == selectedMain) {
                    subMenu.appendChild(opt.cloneNode(true));
                }
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const mainMenu = document.getElementById("main_menu_id");
        const subMenu = document.getElementById("sub_menu_id");
        const allSubOptions = Array.from(subMenu.querySelectorAll("option[data-parent]"));

        mainMenu.addEventListener("change", function() {
            const selectedMain = this.value;

            // نظف القائمة الفرعية
            subMenu.innerHTML = "";
            const defaultOption = new Option("-- اختر من القائمة --", "", true, true);
            defaultOption.disabled = true;
            subMenu.appendChild(defaultOption);

            // أضف فقط الفرعيات التابعة للقائمة الرئيسية المختارة
            allSubOptions.forEach(opt => {
                if (opt.getAttribute("data-parent") == selectedMain) {
                    subMenu.appendChild(opt.cloneNode(true));
                }
            });
        });
    });
</script>

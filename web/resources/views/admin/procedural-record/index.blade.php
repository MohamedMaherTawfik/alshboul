@extends('layouts.admin')

@section('title', 'تفاصيل السجل الإجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'عرض')

@section('content')
    <!-- بيانات القضية -->
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-header bg-dark text-white text-center fw-bold" style="font-size: 1.3rem;">
            بيانات القضية التنفيذية
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>اسم مشترك</th>
                            <th>اسم الموكل</th>
                            <th>الرقم الوطني </th>
                            <th>اسم الخصم</th>
                            <th>الرقم الوطني للخصم</th>
                            <th>رقم الدعوي</th>
                            <th>قيمه الدعوي</th>
                            <th>رقم الملف</th>
                            <th>الدائره</th>
                            <th>المحكوم له</th>
                            <th>المحكوم عليه</th>
                            <th>حالة الدعوي</th>
                            <th>نوع السند التنفيذي</th>
                            <th>رقم السند التنفيذي</th>
                            <th>تاريخ الجلسة الإجرائية</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $executiveCase->client?->name ?? 'غير محدد' }}</td>
                            <td>{{ $executiveCase->client_name ?? 'غير محدد' }}</td>
                            <td>{{ $executiveCase->client_national_id ?? 'غير محدد' }}</td>
                            <td>
                                @foreach ($executiveCase->opponents as $item)
                                    {{ $item->case_opponent_name ?? '-' }} -
                                @endforeach
                            </td>
                            <td>
                                @foreach ($executiveCase->opponents as $item)
                                    {{ $item->case_opponent_national_number ?? '-' }} -
                                @endforeach
                            </td>
                            <td>{{ $executiveCase->case_number ?? '-' }}</td>
                            <td>{{ $executiveCase->case_value ?? '-' }}</td>
                            <td>{{ $executiveCase->file_number ?? '-' }}</td>
                            <td>{{ $executiveCase->execution_court ?? '-' }}</td>
                            <td>{{ $executiveCase->judged_for ?? '-' }}</td>
                            <td>{{ $executiveCase->judged_against ?? '-' }}</td>
                            <td>{{ $executiveCase->case_status ?? '-' }}</td>
                            <td>{{ $executiveCase->execution_document_type ?? '-' }}</td>
                            <td>{{ $executiveCase->execution_document_number ?? '-' }}</td>
                            <td>{{ $executiveCase->procedural_session_date ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- إضافة جلسة أو إجراء -->
    <div class="d-flex justify-content-between mb-3">
        @if ($settlements && $settlements->obligation == 'غير ملتزم')
            <a href="{{ route('procedural-record.create', $executiveCase) }}"
                class="btn btn-dark btn-sm px-3 text-white d-flex align-items-center">
                <i class="bi bi-plus-circle me-1"></i> إضافة جلسة أو إجراء
            </a>
        @endif

        @if (!$settlements)
            <a href="{{ route('procedural-record.create', $executiveCase) }}"
                class="btn btn-dark btn-sm px-3 text-white d-flex align-items-center">
                <i class="bi bi-plus-circle me-1"></i> إضافة جلسة أو إجراء
            </a>
        @endif

        <!-- فلترة -->
        <div class="d-flex gap-2 mr-2">
            <select id="filterType" class="form-select form-select-sm" style="width:auto;"
                onchange="filterSessions(this.value)">
                <option value="all">عرض الكل</option>
                <option value="جلسة">الجلسات فقط</option>
                <option value="إجراء">الإجراءات فقط</option>
            </select>
        </div>

    </div>

    <!-- جدول الجلسات والإجراءات -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>اسم المدخل</th>
                        <th>المحامي</th>
                        <th>النوع</th>
                        <th>وقائع الدعوي</th>
                        <th>ملاحظات</th>
                        <th>تاريخ الإجراء/الجلسة</th>
                        <th>تاريخ الإدخال</th>
                        <th>الإجراء القادم</th>
                        <th>الملفات</th>
                        @if (Auth::user()->role = 'doctor' || (Auth::user()->role = 'superadmin' || (Auth::user()->role = 'admin')))
                            <th>عمليات</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="sessionsTable">
                    @forelse ($executiveCase->proceduralRecords->sortByDesc('created_at') as $record)
                        <tr data-type="{{ $record->type }}">
                            <td>{{ $record->userLawyer?->name ?? '-' }}</td>
                            <td>{{ $record->user?->name ?? 'بلا' }}</td>
                            <td>{{ $record->type ?? '-' }}</td>
                            <td>{{ $record->action ?? '-' }}</td>
                            <td>{{ $record->note ?? '-' }}</td>
                            <td>{{ $record->date ? date('d/m/Y', strtotime($record->date)) : '-' }}</td>
                            <td>{{ $record->created_at ? $record->created_at->format('d/m/Y h:i') : '-' }}</td>
                            <td>{{ $record->next_action_date ? $record->next_action . ' (' . $record->next_action_date . ')' : '-' }}
                            </td>
                            <td>
                                <a href="{{ route('proceduralfiles.index', $record) }}">
                                    (عدد المستندات : <span class="text-success fs-5">{{ count($record->files) }}</span>)
                                </a>
                            </td>
                            @if (Auth::user()->role = 'doctor' || (Auth::user()->role = 'superadmin' || (Auth::user()->role = 'admin')))
                                <td>
                                    <a href="{{ route('procedural-record.edit', $record->id) }}"
                                        class="btn btn-sm btn-warning">تعديل</a>

                                    @if (Auth::user()->role = 'doctor' || (Auth::user()->role = 'superadmin'))
                                        <form action="{{ route('procedural-record.delete', $record->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                        </form>
                                    @endif


                                </td>
                            @endif


                        </tr>

                        <!-- مودال رفع ملفات -->
                        <div class="modal fade" id="addFileModal-{{ $record->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('executive-case.add.file', $record->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">رفع مستندات ({{ $record->type }})</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="file" name="files[]" class="form-control" multiple required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-primary">رفع</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    function normalizeType(value) {
        value = value.trim().toLowerCase();

        if (value === 'جلسة' || value === 'جلسه') {
            return 'جلسة';
        }
        if (value === 'إجراء' || value === 'اجراء') {
            return 'إجراء';
        }
        return value;
    }

    function filterSessions(type) {
        let rows = document.querySelectorAll("#sessionsTable tr");

        rows.forEach(row => {
            let rowType = normalizeType(row.dataset.type || '');
            let filterType = normalizeType(type);

            if (filterType === 'all') {
                row.style.display = '';
            } else {
                if (rowType === filterType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }
</script>

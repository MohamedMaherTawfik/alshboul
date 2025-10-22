@extends('layouts.admin')

@section('title', 'تفاصيل السجل الإجرائي')
@section('main_title_content', 'تفاصيل السجل الإجرائي')
@section('title_content', 'عرض')

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white text-center fw-bold" style="font-size: 1.3rem;">
            بيانات القضية
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-0 text-center align-middle"
                    style="font-size: 1.1rem; direction: rtl;">
                    <thead class="table-dark text-white">
                        <tr>
                            <th>اسم المشترك</th>
                            <th>اسم الموكل</th>
                            <th>الرقم الوطني</th>
                            <th>اسم الخصم</th>
                            <th>الرقم الوطني للخصم</th>
                            <th>رقم الدعوى</th>
                            <th>قيمة الدعوى</th>
                            <th>رقم الملف</th>
                            <th>المحكمة</th>
                            <th>اسم القاضي</th>
                            <th>تاريخ الجلسة القادمة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $lastSession = $case->courtSession->first();
                            $hoursLeft = null;
                            if ($lastSession && !empty($lastSession->date)) {
                                $hoursLeft = \Carbon\Carbon::now()->diffInHours(
                                    \Carbon\Carbon::parse($lastSession->date),
                                    false,
                                );
                            }
                        @endphp
                        <tr>
                            <td>{{ $case->subscriber->name ?? '-' }}</td>
                            <td>{{ $case->client->name ?? '-' }}</td>
                            <td>{{ $case->first_national_id ?? '-' }}</td>
                            <td>
                                @forelse ($case->caseOpponents as $item)
                                    {{ $item->case_opponent_name ?? '-' }} <br>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td>
                                @forelse ($case->caseOpponents as $item)
                                    {{ $item->case_opponent_national_number ?? '-' }} <br>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td>{{ $case->file_number ?? '-' }}</td>
                            <td>{{ $case->case_amount ?? '-' }}</td>
                            <td>{{ $case->case_number ?? '-' }}</td>
                            <td>{{ $case->court_name ?? '-' }}</td>
                            <td>{{ $case->jubge_name ?? '-' }}</td>
                            <td>
                                {{ $case->courtSession->last()->date ?? 'لا يوجد جلسات' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- إضافة جلسة أو إجراء + فلترة -->
    <div class="d-flex justify-content-between mb-3">
        @if (!$more)
            <a href="{{ route('cases.add', $case) }}" class="btn btn-dark btn-sm px-3 text-white d-flex align-items-center">
                <i class="bi bi-plus-circle me-1"></i> إضافة جلسة او اجراء
            </a>
        @endif


        <!-- فلترة -->
        <div class="d-flex gap-2 mr-2">
            <select id="filterType" class="form-select form-select-sm" style="width:auto;"
                onchange="filterSessions(this.value)">
                <option value="all">عرض الكل</option>
                <option value="session">الجلسات فقط</option>
                <option value="procedure">الإجراءات فقط</option>
            </select>
        </div>
    </div>

    <!-- جدول الجلسات والإجراءات -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>رقم الاجراء</th>
                        <th>اسم المدخل</th>
                        <th>المحامي</th>
                        <th>تاريخ الإدخال</th>
                        <th>الوقائع</th>
                        <th>ملاحظات</th>
                        <th>تاريخ الجلسة / الإجراء</th>
                        <th>الملفات</th>
                        <th>النوع</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody id="sessionsTable">
                    @forelse ($case->proceduralRedords->sortByDesc('created_at') as $record)
                        @php
                            $type = $record->date ? 'جلسة' : 'إجراء';
                        @endphp
                        <tr data-type="{{ $type === 'جلسة' ? 'session' : 'procedure' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $record->userLawyer->name ?? '-' }}</td>
                            <td>{{ $record->user->name ?? '-' }}</td>
                            <td>{{ $record->created_at ? $record->created_at->format('d/m/Y') : '-' }}</td>
                            <td>{{ $record->action ?? '-' }}</td>
                            <td>{{ $record->note ?? '-' }}</td>
                            <td>{{ $record->date ?? '-' }}</td>
                            <td>
                                @foreach ($record->files as $file)
                                    <a href="{{ asset('storage/' . ($file->file_path ?? $file->file)) }}"
                                        class="btn btn-sm btn-info mb-1" target="_blank">عرض</a>
                                @endforeach
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#addFileModal-{{ $record->id }}">+</button>
                            </td>
                            <td>{{ $type }}</td>
                            <td>
                                @if ($record->date)
                                    <a href="{{ route('cases.procedure.edit', $record) }}"
                                        class="btn btn-sm btn-warning">تعديل
                                        الجلسة</a>
                                @else
                                    <a href="{{ route('cases.procedure.edit', $record) }}"
                                        class="btn btn-sm btn-warning">تعديل الإجراء</a>
                                    {{-- <a href="{{ route('case.procedural.show', $record) }}"
                                        class="btn btn-sm btn-info">إجراء
                                        فرعي</a> --}}
                                @endif

                                <form
                                    action="{{ $record->type === 'جلسة' ? route('cases.procedure.delete', $record) : route('cases.procedure.delete', $record) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                </form>
                            </td>
                        </tr>

                        <!-- مودال رفع ملفات -->
                        <div class="modal fade" id="addFileModal-{{ $record->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST"
                                        action="{{ $case->type === 'جلسة' ? route('procedural.add.file', $record) : route('procedural.add.file', $record) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">رفع مستندات ({{ $type }})</h5>
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
                            <td colspan="9" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function filterSessions(type) {
            let rows = document.querySelectorAll("#sessionsTable tr");
            rows.forEach(row => {
                if (type === 'all' || row.dataset.type === type) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection

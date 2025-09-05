@extends('layouts.admin')
@section('title', 'تفاصيل القضية')
@section('main_title_content', 'تفاصيل القضية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('cases.all') }}">
        جميع القضايا</a>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white fw-bold">
                تفاصيل القضية
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>رقم الملف</th>
                                <th>الموكل</th>
                                <th>الرقم الوطني الأول</th>
                                <th>اسم الخصم</th>
                                <th>الرقم الوطني للخصم</th>
                                <th>حاله القضيه </th>
                                <th>نوع القضية</th>
                                <th>رقم الدعوي</th>
                                <th>المحكمة</th>
                                <th>قيمة القضية</th>
                                <th>اسم القاضي</th>
                                <th>تفاصيل القضية</th>
                                <th>وصف الموكل</th>
                                <th>وصف الخصم</th>
                                <th>أضيف بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $case->case_number ?? '-' }}</td>
                                <td>{{ $case->client->name ?? '-' }}</td>
                                <td>{{ $case->first_national_id ?? '-' }}</td>
                                <td>
                                    @foreach ($case->caseOpponents as $item)
                                        {{ $item->case_opponent_name ?? '-' }} -
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($case->caseOpponents as $item)
                                        {{ $item->case_opponent_national_number ?? '-' }} -
                                    @endforeach
                                </td>
                                <td>{{ $case->suggestedCases->name ?? '-' }}</td>
                                <td>{{ $case->case_type ?? '-' }}</td>
                                <td>{{ $case->file_number ?? '-' }}</td>
                                <td>{{ $case->court_name ?? '-' }}</td>
                                <td>{{ $case->case_amount ?? '-' }}</td>
                                <td>{{ $case->jubge_name ?? '-' }}</td>
                                <td>{{ $case->case_details ?? '-' }}</td>
                                <td>{{ $case->client_description ?? '-' }}</td>
                                <td>
                                    @foreach ($case->caseOpponents as $item)
                                        {{ $item->case_opponent_description ?? '-' }} -
                                    @endforeach
                                </td>
                                <td>{{ $case->added_by->name ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= جدول مواعيد الجلسات ================= --}}
    <!-- سكشن الفلترة والإضافة -->
    <!-- سكشن الفلترة والإضافة -->
    <section class="mb-5">
        <div class="card shadow-sm">
            <div class="card-body d-flex align-items-center justify-content-between">
                <!-- زرار إضافة -->
                <a href="{{ route('cases.add', $case) }}"
                    class="btn btn-dark btn-sm px-3 text-white d-flex align-items-center">
                    <i class="bi bi-plus-circle me-1"></i> إضافة جلسة او اجراء
                </a>

                <!-- أزرار الفلترة -->
                <div class="d-flex gap-2">
                    <button class="btn btn-primary btn-sm mr-2" onclick="filterSessions('all')">عرض الكل</button>
                    <button class="btn btn-success btn-sm mr-2" onclick="filterSessions('session')">الجلسات فقط</button>
                    <button class="btn btn-info btn-sm mr-2" onclick="filterSessions('procedure')">الإجراءات فقط</button>
                </div>
            </div>
        </div>
    </section>

    <!-- جدول الجلسات والإجراءات -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>اسم المدخل</th>
                        <th>التاريخ</th>
                        <th>المحامي</th>
                        <th>النوع</th>
                        <th>الوقائع</th>
                        <th>الملفات</th>
                        <th>ملاحظات</th>
                        <th>تاريخ الإدخال</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody id="sessionsTable">
                    @forelse ($sessions as $session)
                        <tr data-type="{{ $session['type'] === 'جلسة' ? 'session' : 'procedure' }}">
                            <td>{{ $session['user'] }}</td>
                            <td>{{ $session['date'] ?? '-' }}</td>
                            <td>{{ $session['lawyer'] }}</td>
                            <td>{{ $session['type'] }}</td>
                            <td>{{ $session['facts'] }}</td>
                            <td>
                                @foreach ($session['files'] as $file)
                                    <a href="{{ asset('storage/' . ($file->file_path ?? $file->file)) }}"
                                        class="btn btn-sm btn-info mb-1" target="_blank">
                                        عرض المستند
                                    </a>
                                @endforeach

                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#addFileModal-{{ $session['type'] }}-{{ $session['id'] }}">
                                    +
                                </button>
                            </td>

                            <td>{{ $session['note'] ?? '-' }}</td>
                            <td>{{ $session['created_at'] ? date('d/m/Y', strtotime($session['created_at'])) : '-' }}
                            </td>
                            <td>
                                @if ($session['type'] === 'جلسة')
                                    <a href="{{ route('cases.session.edit', $session['id']) }}"
                                        class="btn btn-sm btn-warning">تعديل الجلسة</a>
                                @else
                                    <a href="{{ route('cases.procedure.edit', $session['id']) }}"
                                        class="btn btn-sm btn-warning">تعديل الإجراء</a>
                                    <a href="{{ route('case.procedural.show', $session['id']) }}"
                                        class="btn btn-sm btn-info">إجراء فرعي</a>
                                @endif

                                <form
                                    action="{{ $session['type'] === 'جلسة'
                                        ? route('cases.session.delete', $session['id'])
                                        : route('cases.procedure.delete', $session['id']) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                </form>
                            </td>
                        </tr>

                        {{-- مودال رفع ملفات --}}
                        <div class="modal fade" id="addFileModal-{{ $session['type'] }}-{{ $session['id'] }}"
                            tabindex="-1" aria-labelledby="addFileModalLabel-{{ $session['id'] }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST"
                                        action="{{ $session['type'] === 'جلسة'
                                            ? route('sessions.uploadFile', $session['id'])
                                            : route('procedural.add.file', $session['id']) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addFileModalLabel-{{ $session['id'] }}">
                                                رفع مستندات {{ $session['type'] }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="files-{{ $session['id'] }}" class="form-label">اختر
                                                    الملفات</label>
                                                <input type="file" name="files[]" id="files-{{ $session['id'] }}"
                                                    class="form-control" multiple required>
                                            </div>
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

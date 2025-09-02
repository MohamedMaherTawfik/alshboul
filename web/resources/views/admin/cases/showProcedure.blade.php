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
                                <td>{{ $case->case_number }}</td>
                                <td>{{ $case->client->name }}</td>
                                <td>{{ $case->first_national_id }}</td>
                                <td>
                                    @foreach ($case->caseOpponents as $item)
                                        {{ $item->case_opponent_name }} -
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($case->caseOpponents as $item)
                                        {{ $item->case_opponent_national_number }} -
                                    @endforeach
                                </td>
                                <td>{{ $case->suggestedCases->name }}</td>
                                <td>{{ $case->case_type }}</td>
                                <td>{{ $case->file_number }}</td>
                                <td>{{ $case->court_name }}</td>
                                <td>{{ $case->case_amount }}</td>
                                <td>{{ $case->jubge_name }}</td>
                                <td>{{ $case->case_details ?? '-' }}</td>
                                <td>{{ $case->client_description ?? '-' }}</td>
                                <td>
                                    @foreach ($case->caseOpponents as $item)
                                        {{ $item->case_opponent_description }} -
                                    @endforeach
                                </td>
                                <td>{{ $case->added_by->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ================== خانات البحث ==================
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <input type="text" id="searchUser" class="form-control" placeholder="بحث باسم المدخل">
        </div>
        <div class="col-md-3">
            <input type="text" id="searchFacts" class="form-control" placeholder="بحث بوقائع المذكرة">
        </div>
        <div class="col-md-3">
            <input type="text" id="searchStart" class="form-control" placeholder="بحث ببداية المدة">
        </div>
        <div class="col-md-3">
            <input type="text" id="searchEnd" class="form-control" placeholder="بحث بنهاية المدة">
        </div>
    </div> --}}

    {{-- ================== المذكرات القانونية ================== --}}
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center gap-2">
            <h5 class="mb-0"><i class="bi bi-file-earmark-text me-3"></i> الاجراءات القانونية </h5>
            <a href="{{ route('cases.procedure.create', $case) }}"
                class="btn btn-warning me-2 btn-sm ms-auto px-3 text-white">
                <i class="bi bi-list me-1"></i> اضافه اجراء
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-bordered table-hover align-middle table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>رقم الملف</th>
                            <th> النوع</th>
                            <th> وقت الادخال</th>
                            <th>رقم القضية</th>
                            <th> المحامي</th>
                            <th>اسم المدخل</th>
                            <th>تاريخ الإدخال</th>
                            <th>وقائع الاجراء</th>
                            <th>مستندات</th>
                            <th>اسم الموكل</th>
                            <th>اسم الخصم</th>
                            <th>اسم المحكمة</th>
                            <th>ملاحظات</th>
                            <th>اجراءات فرعيه</th>
                            {{-- @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                <th>الاجراءات</th>
                            @endif --}}

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($case->proceduralRedords as $duration)
                            <tr>
                                <td>{{ $case->case_number ?? '-' }}</td>
                                <td>{{ $duration->type ?? '-' }}</td>
                                <td>{{ $duration->created_at->format('Y-m-d') ?? '-' }}</td>
                                <td>
                                    {{ $case->file_number ?? '-' }}
                                    <a href="{{ route('cases.show', $case) }}" class="ms-2 text-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <td>{{ $duration->user->name ?? '-' }}</td>
                                <td>{{ $duration->created_by ?? '-' }}</td>
                                <td>{{ $duration->created_at?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ $duration->action }}</td>
                                <td>
                                    @foreach ($duration->files as $item)
                                        <a href="{{ asset('storage/' . $item->file_path) }} "
                                            class="btn btn-sm btn-primary" target="_blank">مستند</a>
                                    @endforeach
                                    <!-- زرار -->
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#addFileModal-{{ $duration->id }}">
                                        +
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="addFileModal-{{ $duration->id }}" tabindex="-1"
                                        aria-labelledby="addFileModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('procedural.add.file', $duration) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addFileModalLabel">إضافة ملفات جديدة
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="إغلاق"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="file_path" class="form-label">اختر الملفات</label>
                                                            <input type="file" name="file_path[]" id="file_path"
                                                                class="form-control" multiple required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">حفظ</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">إلغاء</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td>{{ $case->client->name ?? '-' }}</td>
                                <td>
                                    @foreach ($case->caseOpponents as $item)
                                        {{ $item->case_opponent_name ?? '-' }} -
                                    @endforeach
                                </td>
                                <td>{{ $case->court_name ?? '-' }}</td>
                                <td>{{ $duration->note ?? '-' }}</td>
                                <td><a href="{{ route('case.procedural.show', $duration) }}" class="btn btn-primary">اجراء
                                        فرعي</a>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <a href="{{ route('case.procedural.edit', $duration) }}"
                                            class="btn btn-warning">تعديل</a>
                                        <form action="{{ route('case.procedural.delete', $duration) }}" method="POST"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">حذف</button>
                                        </form>
                                    @endif
                                </td>
                                {{-- @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <td>
                                        <form action="{{ route('case.duration.submit', $duration) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> انجاز
                                            </button>
                                        </form>
                                    </td>
                                @endif --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">لا توجد مدد مسجلة</td>
                            </tr>
                        @endforelse
                    </tbody>


                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchUser = document.getElementById('searchUser');
            const searchFacts = document.getElementById('searchFacts');
            const searchStart = document.getElementById('searchStart');
            const searchEnd = document.getElementById('searchEnd');

            const tableRows = document.querySelectorAll('table tbody tr');

            function filterTable() {
                const userVal = searchUser.value.toLowerCase();
                const factsVal = searchFacts.value.toLowerCase();
                const startVal = searchStart.value.toLowerCase();
                const endVal = searchEnd.value.toLowerCase();

                tableRows.forEach(row => {
                    const userCell = row.cells[2]?.innerText.toLowerCase() || ''; // اسم المدخل
                    const factsCell = row.cells[4]?.innerText.toLowerCase() || ''; // وقائع المذكرة
                    const startCell = row.cells[5]?.innerText.toLowerCase() || ''; // بداية المدة
                    const endCell = row.cells[6]?.innerText.toLowerCase() || ''; // نهاية المدة

                    const matchesUser = userCell.includes(userVal);
                    const matchesFacts = factsCell.includes(factsVal);
                    const matchesStart = startCell.includes(startVal);
                    const matchesEnd = endCell.includes(endVal);

                    if (matchesUser && matchesFacts && matchesStart && matchesEnd) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            [searchUser, searchFacts, searchStart, searchEnd].forEach(input => {
                input.addEventListener('input', filterTable);
            });
        });
    </script>

    </div>
@endsection

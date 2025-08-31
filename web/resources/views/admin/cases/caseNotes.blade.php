@extends('layouts.admin')
@section('title', 'تفاصيل القضية')
@section('main_title_content', 'تفاصيل القضية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('cases.all') }}"> جميع القضايا</a>
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
                                <th>الرقم القومي الأول</th>
                                <th>اسم الخصم</th>
                                <th>الرقم القومي للخصم</th>
                                <th>القضية المقترحة</th>
                                <th>نوع القضية</th>
                                <th>رقم الدعوي</th>
                                <th>المحكمة</th>
                                <th>قيمة القضية</th>
                                <th>تاريخ الاستفادة</th>
                                <th>اسم القاضي</th>
                                <th>تفاصيل القضية</th>
                                <th>وصف الموكل</th>
                                <th>معلومات عامة</th>
                                <th>معلومات خاصة</th>
                                <th>أضيف بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $case->case_number }}</td>
                                <td>{{ $case->client->name }}</td>
                                <td>{{ $case->first_national_id }}</td>
                                <td>{{ $case->opponent_name }}</td>
                                <td>{{ $case->opponent_national_id }}</td>
                                <td>{{ $case->suggestedCases->name }}</td>
                                <td>{{ $case->case_type }}</td>
                                <td>{{ $case->file_number }}</td>
                                <td>{{ $case->court_name }}</td>
                                <td>{{ $case->case_amount }}</td>
                                <td>{{ $case->benefit_date }}</td>
                                <td>{{ $case->jubge_name }}</td>
                                <td>{{ $case->case_details ?? '-' }}</td>
                                <td>{{ $case->client_description ?? '-' }}</td>
                                <td>{{ $case->general_information ?? '-' }}</td>
                                <td>{{ $case->private_information ?? '-' }}</td>
                                <td>{{ $case->added_by->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ================== خانات البحث ================== --}}
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
    </div>

    {{-- ================== المذكرات القانونية ================== --}}
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center gap-2">
            <h5 class="mb-0"><i class="bi bi-file-earmark-text me-3"></i> المذكرات القانونية </h5>
            <a href="{{ route('cases.notes.create', $case) }}" class="btn btn-warning me-2 btn-sm ms-auto px-3 text-white">
                <i class="bi bi-list me-1"></i> اضافه مذكره
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-bordered table-hover align-middle table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>رقم الملف</th>
                            <th>رقم القضية</th>
                            <th>اسم المدخل</th>
                            <th>تاريخ الإدخال</th>
                            <th>وقائع المذكرة</th>
                            <th>بداية المدة</th>
                            <th>نهاية المدة</th>
                            <th>اسم الموكل</th>
                            <th>اسم الخصم</th>
                            <th>اسم المحكمة</th>
                            <th>ملاحظات</th>
                            <th>المعتمد الأول</th>
                            <th>المعتمد الثاني</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                <th>الاجراءات</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($case->caseNotes as $duration)
                            @php
                                $rowClass = '';
                                if ($duration->period_end) {
                                    // عمل object للتاريخ النهائي بتوقيت الأردن
                                    $endDateObj = new DateTime($duration->period_end, new DateTimeZone('Asia/Amman'));
                                    $endDate = $endDateObj->format('Y-m-d');

                                    // تاريخ اليوم بتوقيت الأردن
                                    $todayObj = new DateTime('now', new DateTimeZone('Asia/Amman'));
                                    $today = $todayObj->format('Y-m-d');

                                    // بكرة بتوقيت الأردن
                                    $tomorrowObj = new DateTime('tomorrow', new DateTimeZone('Asia/Amman'));
                                    $tomorrow = $tomorrowObj->format('Y-m-d');

                                    if ($endDate === $today) {
                                        // لو النهارده
                                        $rowClass = 'bg-danger text-white fw-bold';
                                    } elseif ($endDate === $tomorrow) {
                                        // لو بكرة
                                        $rowClass = 'bg-warning fw-bold';
                                    }
                                }
                            @endphp


                            <tr class="{{ $rowClass }}">
                                <td>{{ $case->case_number ?? '-' }}</td>
                                <td>
                                    {{ $case->file_number ?? '-' }}
                                    <a href="{{ route('cases.show', $case) }}" class="ms-2 text-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <td>{{ $duration->user->name ?? '-' }}</td>
                                <td>{{ $duration->created_at?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ Str::limit($duration->period_facts, 50, '...') }}</td>
                                <td>{{ $duration->period_start ?? '-' }}</td>
                                <td>{{ $duration->period_end ?? '-' }}</td>
                                <td>{{ $case->client->name ?? '-' }}</td>
                                <td>{{ $case->opponent_name ?? '-' }}</td>
                                <td>{{ $case->court_name ?? '-' }}</td>
                                <td>{{ Str::limit($duration->notes, 40, '...') ?? '-' }}</td>
                                <td>{{ $duration->firstSubmitter->name ?? '-' }}</td>
                                <td>{{ $duration->secondSubmitter->name ?? '-' }}</td>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <td>
                                        <form action="{{ route('case.duration.submit', $duration) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> انجاز
                                            </button>
                                        </form>
                                    </td>
                                @endif
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

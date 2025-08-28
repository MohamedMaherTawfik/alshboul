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

    {{-- ================== المدد القانونية ================== --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center gap-2">
            <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i> المدد القانونية </h5>
            <span class="badge bg-primary fs-6 px-3 py-2">{{ $case->legalPeriods->count() }} مدة</span>
            <a href="{{ route('duration.all') }}" class="btn btn-primary btn-sm ms-auto px-3 text-white">
                <i class="bi bi-list me-1"></i> جميع المدد
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
                            <th>وقائع المدة</th>
                            <th>بداية المدة</th>
                            <th>نهاية المدة</th>
                            <th>اسم الموكل</th>
                            <th>اسم الخصم</th>
                            <th>اسم المحكمة</th>
                            <th>ملاحظات</th>
                            <th>المعتمد الأول</th>
                            <th>المعتمد الثاني</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($case->legalPeriods as $duration)
                            <tr>
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
                                @php
                                    $isTomorrow = false;
                                    if ($duration->period_end) {
                                        $endDate = date('Y-m-d', strtotime($duration->period_end)); // التاريخ فقط
                                        $today = date('Y-m-d'); // تاريخ النهارده
                                        $tomorrow = date('Y-m-d', strtotime('+1 day')); // تاريخ بكرة

                                        if ($endDate === $tomorrow) {
                                            $isTomorrow = true;
                                        }
                                    }
                                @endphp

                                <td @if ($isTomorrow) class="text-danger fw-bold" @endif>
                                    {{ $duration->period_end ?? '-' }}
                                </td>


                                <td>{{ $case->client->name ?? '-' }}</td>
                                <td>{{ $case->opponent_name ?? '-' }}</td>
                                <td>{{ $case->court_name ?? '-' }}</td>
                                <td>{{ Str::limit($duration->notes, 40, '...') ?? '-' }}</td>
                                <td>{{ $duration->firstSubmitter->name ?? '-' }}</td>
                                <td>{{ $duration->secondSubmitter->name ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('case.duration.submit', $duration) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> انجاز
                                        </button>
                                    </form>
                                </td>
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


    {{-- ================== المذكرات القانونية ================== --}}
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center gap-2">
            <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i> المذكرات القانونية </h5>
            <span class="badge bg-primary fs-6 px-3 py-2">{{ $case->caseNotes->count() }} مذكرة</span>
            <a href="{{ route('note.all') }}" class="btn btn-primary btn-sm ms-auto px-3 text-white">
                <i class="bi bi-list me-1"></i> جميع المذكرات
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
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($case->caseNotes as $note)
                            <tr>
                                <td>{{ $case->case_number ?? '-' }}</td>
                                <td>
                                    {{ $case->file_number ?? '-' }}
                                    <a href="{{ route('cases.show', $case) }}" class="ms-2 text-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <td>{{ $note->user->name ?? '-' }}</td>
                                <td>{{ $note->created_at?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ Str::limit($note->period_facts, 50, '...') }}</td>
                                <td>{{ $note->period_start ?? '-' }}</td>
                                @php
                                    $isToday = false;
                                    $isTomorrow = false;

                                    if ($note->period_end) {
                                        // رجّع التاريخ بس من غير وقت
                                        $endDate = date('Y-m-d', strtotime($note->period_end));
                                        $today = date('Y-m-d');
                                        $tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));

                                        if ($endDate === $today) {
                                            $isToday = true;
                                        } elseif ($endDate === $tomorrow) {
                                            $isTomorrow = true;
                                        }
                                    }
                                @endphp

                                <td
                                    @if ($isToday) class="text-warning fw-bold"
    @elseif($isTomorrow) class="text-danger fw-bold" @endif>
                                    {{ date('Y-m-d', strtotime($note->period_end)) ?? '-' }}
                                </td>



                                <td>{{ $case->client->name ?? '-' }}</td>
                                <td>{{ $case->opponent_name ?? '-' }}</td>
                                <td>{{ $case->court_name ?? '-' }}</td>
                                <td>{{ Str::limit($note->notes, 40, '...') ?? '-' }}</td>
                                <td>{{ $note->firstSubmitter->name ?? '-' }}</td>
                                <td>{{ $note->secondSubmitter->name ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('case.note.submit', $note) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> انجاز
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">لا توجد مذكرات مسجلة</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- ================= جدول مواعيد الجلسات ================= --}}
    <h3 class="mt-5">مواعيد الجلسات</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>التاريخ</th>
                <th>النوع</th>
                <th>الوقائع</th>
                <th>الملف</th>
                <th>الملاحظات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($case->courtSession as $session)
                <tr>
                    <td>{{ $session->id }}</td>
                    <td>{{ $session->date }}</td>
                    <td>{{ $session->type }}</td>
                    <td>{{ $session->facts }}</td>
                    <td>
                        @if ($session->file)
                            <a href="{{ asset('storage/' . $session->file) }}" target="_blank">عرض الملف</a>
                        @else
                            لا يوجد
                        @endif
                    </td>
                    <td>{{ $session->note }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">لا توجد جلسات</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    </div>
@endsection

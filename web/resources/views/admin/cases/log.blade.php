@extends('layouts.admin')

@section('title', 'سجل القضية')
@section('main_title_content', 'سجل القضية')

@section('content')
    @php
        use Illuminate\Support\Str;
        use Carbon\Carbon;
    @endphp

    <div class="col-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pt-3 pb-2">
                <h4 class="mb-0 fw-bold"><i class="bi bi-journal-text me-2"></i> سجل القضية رقم:
                    {{ $case->case_number ?? '-' }}
                </h4>
            </div>
        </div>

        {{-- ================== المدد القانونية ================== --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center gap-2">
                <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i> المدد القانونية </h5>
                {{-- <a href="{{ route('cases.duration.create', $case) }}"
                    class="btn btn-warning me-2 btn-sm ms-auto px-3 text-white">
                    <i class="bi bi-plus-lg me-1"></i> إضافة مدة
                </a> --}}
            </div>
            <div class="card-body">

                {{-- خانات البحث
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <input type="text" id="searchStart" class="form-control" placeholder="بحث ببداية المدة">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="searchEnd" class="form-control" placeholder="بحث بنهاية المدة">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="searchUser" class="form-control" placeholder="بحث باسم المدخل">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="searchFacts" class="form-control" placeholder="بحث بوقائع المدة">
                    </div>
                </div> --}}

                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-bordered table-hover align-middle table-striped mb-0" id="durationsTable">
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
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <th>الإنجاز</th>
                                    <th>الإجراءات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($case->legalPeriods as $duration)
                                @php
                                    $rowClass = '';
                                    if ($duration->period_end) {
                                        $endDateObj = new DateTime(
                                            $duration->period_end,
                                            new DateTimeZone('Asia/Amman'),
                                        );
                                        $endDate = $endDateObj->format('Y-m-d');
                                        $todayObj = new DateTime('now', new DateTimeZone('Asia/Amman'));
                                        $today = $todayObj->format('Y-m-d');
                                        $tomorrowObj = new DateTime('tomorrow', new DateTimeZone('Asia/Amman'));
                                        $tomorrow = $tomorrowObj->format('Y-m-d');
                                        if ($endDate === $today) {
                                            $rowClass = 'bg-danger text-white fw-bold';
                                        } elseif ($endDate === $tomorrow) {
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
                                    <td>
                                        @foreach ($case->caseOpponents as $item)
                                            {{ $item->case_opponent_name }} -
                                        @endforeach
                                    </td>
                                    <td>{{ $case->court_name ?? '-' }}</td>
                                    <td>{{ Str::limit($duration->notes, 40, '...') ?? '-' }}</td>
                                    <td>{{ $duration->firstSubmitter->name ?? '-' }}</td>
                                    <td>{{ $duration->secondSubmitter->name ?? '-' }}</td>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <td>
                                            <form action="{{ route('case.duration.submit', $duration) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> إنجاز
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('cases.durations.edit', $duration) }}"
                                                    class="btn btn-sm btn-info d-flex align-items-center ml-2">
                                                    <i class="fas fa-edit me-1"></i> تعديل
                                                </a>
                                                <form action="{{ route('cases.durations.delete', $duration) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذه المدة؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-dark d-flex align-items-center">
                                                        <i class="fas fa-trash me-1"></i> حذف
                                                    </button>
                                                </form>
                                            </div>
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

        {{-- ================== المذكرات القانونية ================== --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center gap-2">
                <h5 class="mb-0"><i class="bi bi-file-earmark-text me-3"></i> المذكرات القانونية </h5>
                {{-- <a href="{{ route('cases.notes.create', $case) }}"
                    class="btn btn-warning me-2 btn-sm ms-auto px-3 text-white">
                    <i class="bi bi-plus-lg me-1"></i> إضافة مذكرة
                </a> --}}
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
                                    <th>الإنجاز</th>
                                    <th>الإجراءات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($case->caseNotes as $duration)
                                @php
                                    $rowClass = '';
                                    if ($duration->period_end) {
                                        $endDateObj = new DateTime(
                                            $duration->period_end,
                                            new DateTimeZone('Asia/Amman'),
                                        );
                                        $endDate = $endDateObj->format('Y-m-d');
                                        $todayObj = new DateTime('now', new DateTimeZone('Asia/Amman'));
                                        $today = $todayObj->format('Y-m-d');
                                        $tomorrowObj = new DateTime('tomorrow', new DateTimeZone('Asia/Amman'));
                                        $tomorrow = $tomorrowObj->format('Y-m-d');
                                        if ($endDate === $today) {
                                            $rowClass = 'bg-danger text-white fw-bold';
                                        } elseif ($endDate === $tomorrow) {
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
                                    <td>
                                        @foreach ($case->caseOpponents as $item)
                                            {{ $item->case_opponent_name }} -
                                        @endforeach
                                    </td>
                                    <td>{{ $case->court_name ?? '-' }}</td>
                                    <td>{{ Str::limit($duration->notes, 40, '...') ?? '-' }}</td>
                                    <td>{{ $duration->firstSubmitter->name ?? '-' }}</td>
                                    <td>{{ $duration->secondSubmitter->name ?? '-' }}</td>
                                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                        <td>
                                            <form action="{{ route('case.duration.submit', $duration) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> إنجاز
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('cases.notes.edit', $duration) }}"
                                                    class="btn btn-sm btn-info d-flex align-items-center ml-2">
                                                    <i class="fas fa-edit me-1"></i> تعديل
                                                </a>
                                                <form action="{{ route('cases.notes.delete', $duration) }}" method="POST"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذه المدة؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-dark d-flex align-items-center">
                                                        <i class="fas fa-trash me-1"></i> حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
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

        {{-- ================== جدول الجلسات والإجراءات ================== --}}
        <div class="card shadow">
            <div class="card-header bg-white border-0 pt-3 pb-2 d-flex align-items-center">
                <h5 class="mb-0"><i class="bi bi-people me-2"></i> الجلسات والإجراءات </h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
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
                    <tbody>
                        @forelse ($case->proceduralRedords->sortByDesc('id') as $record)
                            @php $type = $record->date ? 'جلسة' : 'إجراء'; @endphp
                            <tr>
                                <td>{{ $record->userLawyer->name ?? '-' }}</td>
                                <td>{{ $record->user->name ?? '-' }}</td>
                                <td>{{ $record->created_at?->format('d/m/Y') ?? '-' }}</td>
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
                                    <a href="{{ route('cases.procedure.edit', $record) }}"
                                        class="btn btn-sm btn-warning">تعديل {{ $type }}</a>
                                    <form action="{{ route('cases.procedure.delete', $record) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- مودال رفع ملفات -->
                            <div class="modal fade" id="addFileModal-{{ $record->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('procedural.add.file', $record) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">رفع مستندات ({{ $type }})</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="إغلاق"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="file" name="files[]" class="form-control" multiple
                                                    required>
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
    </div>
@endsection

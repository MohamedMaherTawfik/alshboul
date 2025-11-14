@extends('layouts.admin')
@section('title', ' الصفحة الرئيسية')
@section('main_title_content', ' الصفحة الرئيسية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('admin.dashboard') }}"> الصفحة الرئيسية</a>
@endsection
@section('content')
    <div class="col-12">
        <h5 class="mt-4 mb-2 text-center">إحصائيات</h5>
        <div class="row">
            <div class="col-lg-4 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $countUser }}</h3>

                        <p>عدد المستخدمين</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('user.index') }}" class="small-box-footer">
                        المستخدمين <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $countClient }}</h3>

                        <p> عدد الموكلين</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <a href="{{ route('client.index') }}" class="small-box-footer">
                        الموكلين <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $countClientRequest }}</h3>

                        <p>عدد طلبات الموكلين</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{ route('request.index') }}" class="small-box-footer">
                        طلبات الموكلين <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <h3> المهملات الحاليه</h3>

            {{-- جدول إحصائيات الكيش تايب --}}
            <h5 class="mt-4">إحصائيات القضايا:</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>نوع الاهمال</th>
                        <th>عدد القضايا المهمله</th>
                        <th>عدد ايام الاهمال</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allData as $row)
                        <tr>
                            <td>{{ $row['name'] }}</td>
                            <td>
                                {{ $row['trashed_count'] }}
                                @if ($row['trashed_count'] > 0)
                                    @if ($row['type'] == 'case_type')
                                        <a href="{{ route('cases.trashed', $row['id']) }}" class="ms-2 text-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @elseif ($row['type'] == 'settlement')
                                        <a href="{{ route('settlement.trashed', $row['id']) }}" class="ms-2 text-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @elseif ($row['type'] == 'executive')
                                        <a href="{{ route('executive.trashed', $row['id']) }}" class="ms-2 text-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @elseif ($row['type'] == 'transaction')
                                        <a href="{{ route('transactions.trashed', $row['id']) }}"
                                            class="ms-2 text-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $row['days'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>




        </div>


        <!-- المدد القانونية -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-3 pb-2 d-flex justify-content-center align-items-center">
                <h5 class="mb-0 text-center w-100">
                    <i class="bi bi-calendar-event me-2"></i>
                    المدد القانونية الموشكه على الانتهاء
                </h5>
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
                                <th>ساعه الإدخال</th>
                                <th>وقائع المدة</th>
                                <th>بداية المدة</th>
                                <th>نهاية المدة</th>
                                <th>اسم الموكل</th>
                                <th>اسم الخصم</th>
                                <th>اسم المحكمة</th>
                                <th>ملاحظات</th>
                                <th>المعتمد الأول</th>
                                <th>المعتمد الثاني</th>
                                @if (Auth::user()->role == 'doctor' || Auth::user()->role == 'superadmin')
                                    <th>الانجاز</th>
                                @endif

                                @if (Auth::user()->role == 'doctor' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin')
                                    <th>الاجراءات</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($durations as $duration)
                                @php
                                    $case = $duration->case;

                                    $showRow = false;
                                    $isNear = false;
                                    $isToday = false;

                                    if (!empty($duration->period_end)) {
                                        $endDate = new DateTime($duration->period_end);
                                        $endDate->modify('+3 hours');

                                        $today = new DateTime('now');
                                        $today->modify('+3 hours');

                                        $endDateStr = $endDate->format('Y-m-d');
                                        $todayStr = $today->format('Y-m-d');

                                        $endTimestamp = strtotime($endDateStr);
                                        $todayTimestamp = strtotime($todayStr);

                                        $diffDays = (int) floor(($endTimestamp - $todayTimestamp) / 86400);

                                        if ($diffDays >= 0 && $diffDays <= 6) {
                                            $showRow = true;
                                        }
                                        if ($diffDays === 0) {
                                            $isToday = true;
                                        }
                                        if ($diffDays === 0) {
                                            $isNear = true;
                                        }
                                    }
                                @endphp

                                @if ($showRow)
                                    <tr class="{{ $isToday ? 'bg-danger text-white fw-bold' : '' }}">
                                        <td>{{ $case->case_number ?? '-' }}</td>
                                        <td>
                                            {{ $case->file_number ?? '-' }}
                                            @if ($case)
                                                <a href="{{ route('cases.show', $case) }}" class="ms-2 text-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $duration->user->name ?? '-' }}</td>
                                        @php
                                            $createdAt = $duration->created_at
                                                ? (clone $duration->created_at)->addHours(3)
                                                : null;
                                        @endphp

                                        <td>{{ $createdAt?->format('Y-m-d') ?? '-' }}</td>
                                        <td>{{ $createdAt?->format('H:i') ?? '-' }}</td>

                                        <td>{{ Str::limit($duration->period_facts, 50, '...') }}</td>
                                        <td>{{ $duration->period_start ?? '-' }}</td>

                                        <td>{{ $endDateStr ?? ($duration->period_end ?? '-') }}</td>

                                        <td>{{ $case->client->name ?? '-' }}</td>
                                        <td>
                                            @foreach ($case->caseOpponents as $item)
                                                {{ $item->case_opponent_name }} -
                                            @endforeach
                                        </td>
                                        <td>{{ $case->court_name ?? '-' }}</td>
                                        <td>{{ Str::limit($duration->notes, 40, '...') ?? '-' }}</td>
                                        <td>
                                            {{ optional($duration->firstSubmitter)->name ?? '-' }} |
                                            {{ $duration->first_time ?? '-' }}
                                        </td>
                                        <td>
                                            {{ optional($duration->secondSubmitter)->name ?? '-' }} |
                                            {{ $duration->second_time ?? '-' }}
                                        </td>

                                        @if (Auth::user()->role == 'doctor' || Auth::user()->role == 'superadmin')
                                            <td>
                                                <form action="{{ route('case.duration.submit', $duration) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check"></i> انجاز
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">

                                                    <!-- زر تعديل -->
                                                    <a href="{{ route('cases.durations.edit', $duration) }}"
                                                        class="btn btn-sm btn-info d-flex align-items-center ml-2">
                                                        <i class="fas fa-edit me-1"></i> تعديل
                                                    </a>

                                                    <!-- زر حذف -->
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
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="mt-4">
            <hr>
        </div>

        {{-- مذكرات القانونية --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-3 pb-2 d-flex justify-content-center align-items-center">
                <h5 class="mb-0 text-center w-100">
                    <i class="bi bi-calendar-event me-2"></i>
                    المذكرات القانونية الموشكه على الانتهاء
                </h5>
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
                                <th>ساعه الإدخال</th>
                                <th>وقائع المذكرة</th>
                                <th>بداية المدة</th>
                                <th>نهاية المدة</th>
                                <th>اسم الموكل</th>
                                <th>اسم الخصم</th>
                                <th>اسم المحكمة</th>
                                <th>ملاحظات</th>
                                <th> المعتمد الأول </th>
                                <th>المعتمد الثاني</th>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
                                    <th>الانجاز</th>
                                @endif
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
                                    <th>الاجراءات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notes as $note)
                                @php
                                    $case = $note->case;
                                    $showRow = false;
                                    $rowClass = '';

                                    // تعديل period_end +3 ساعات
                                    if (!empty($note->period_end)) {
                                        $endDateObj = new DateTime($note->period_end);
                                        $endDateObj->modify('+3 hours');

                                        $todayObj = new DateTime('now');
                                        $todayObj->modify('+3 hours');

                                        $endDateStr = $endDateObj->format('Y-m-d');
                                        $todayStr = $todayObj->format('Y-m-d');

                                        $endTimestamp = strtotime($endDateStr);
                                        $todayTimestamp = strtotime($todayStr);

                                        $diffDays = (int) floor(($endTimestamp - $todayTimestamp) / 86400);

                                        if ($diffDays >= 0 && $diffDays <= 6) {
                                            $showRow = true;
                                            if ($diffDays === 0) {
                                                $rowClass = 'bg-danger text-white fw-bold';
                                            }
                                        }
                                    }

                                    // تعديل created_at +3 ساعات
                                    $createdAt = $note->created_at ? (clone $note->created_at)->addHours(3) : null;
                                @endphp

                                @if ($showRow)
                                    <tr class="{{ $rowClass }}">
                                        <td>{{ $case->case_number ?? '-' }}</td>
                                        <td>
                                            {{ $case->file_number ?? '-' }}
                                            @if ($case)
                                                <a href="{{ route('cases.show', $case) }}" class="ms-2 text-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $note->user->name ?? '-' }}</td>
                                        <td>{{ $createdAt?->format('Y-m-d') ?? '-' }}</td>
                                        <td>{{ $createdAt?->format('H:i') ?? '-' }}</td>
                                        <td>{{ Str::limit($note->period_facts, 50, '...') }}</td>
                                        <td>{{ $note->period_start ?? '-' }}</td>

                                        <td>{{ $endDateStr ?? ($note->period_end ?? '-') }}</td>

                                        <td>{{ $case->client->name ?? '-' }}</td>
                                        <td>
                                            @foreach ($case->caseOpponents as $item)
                                                {{ $item->case_opponent_name }} -
                                            @endforeach
                                        </td>
                                        <td>{{ $case->court_name ?? '-' }}</td>
                                        <td>{{ Str::limit($note->notes, 40, '...') ?? '-' }}</td>
                                        <td>
                                            {{ optional($note->firstSubmitter)->name ?? '-' }} |
                                            {{ $note->first_time ?? '-' }}
                                        </td>
                                        <td>
                                            {{ optional($note->secondSubmitter)->name ?? '-' }} |
                                            {{ $note->second_time ?? '-' }}
                                        </td>


                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
                                            <td>
                                                <form action="{{ route('case.note.submit', $note) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check"></i> انجاز
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'doctor')
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">

                                                    <!-- زر تعديل -->
                                                    <a href="{{ route('cases.notes.edit', $note) }}"
                                                        class="btn btn-sm btn-info d-flex align-items-center ml-2">
                                                        <i class="fas fa-edit me-1"></i> تعديل
                                                    </a>

                                                    <!-- زر حذف -->
                                                    <form action="{{ route('cases.notes.delete', $note) }}" method="POST"
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
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection

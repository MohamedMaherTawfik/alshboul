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
            <div class="col-lg-3 col-6">
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
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $countLawyer }}</h3>

                        <p>إجمالي المحامين </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="{{ route('lawyer.index') }}" class="small-box-footer">
                        المحامين <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
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
            <div class="col-lg-3 col-6">
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
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نوع رئيسي</th>
                        <th>الاسم</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trashed as $item)
                        <tr>
                            <td>{{ $item->id }}</td>

                            {{-- لو جاي من قضية --}}
                            @if ($item->cases)
                                <td>قضية</td>
                                <td>{{ $item->cases->caseType->name ?? '-' }}</td>

                                {{-- لو جاي من قضية تنفيذية --}}
                            @elseif($item->executiveCase)
                                <td>قضية تنفيذية</td>
                                <td>{{ $item->executiveCase->mainExecutiveCases->name ?? '-' }}</td>

                                {{-- لو جاي من تسوية --}}
                            @elseif($item->settlement)
                                <td>تسوية</td>
                                <td>{{ $item->settlement->settlementMain->name ?? '-' }}</td>
                            @else
                                <td>-</td>
                                <td>-</td>
                            @endif
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
                                    <th>إجراء</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($durations as $duration)
                                @php
                                    $case = $duration->case;

                                    $showRow = false;
                                    $isNear = false; // لو قريب (اليوم أو بكرة)
                                    $isToday = false; // لو النهارده

                                    if (!empty($duration->period_end)) {
                                        // نحسب التاريخ حسب توقيت الأردن
                                        $endDate = new DateTime($duration->period_end, new DateTimeZone('Asia/Amman'));
                                        $today = new DateTime('now', new DateTimeZone('Asia/Amman'));

                                        $endDateStr = $endDate->format('Y-m-d');
                                        $todayStr = $today->format('Y-m-d');

                                        $endTimestamp = strtotime($endDateStr);
                                        $todayTimestamp = strtotime($todayStr);

                                        $diffDays = (int) floor(($endTimestamp - $todayTimestamp) / 86400);

                                        // لو باقي 0..6 يوم -> نظهر الصف
                                        if ($diffDays >= 0 && $diffDays <= 6) {
                                            $showRow = true;
                                        }

                                        // لو باقي 0 -> النهارده
                                        if ($diffDays === 0) {
                                            $isToday = true;
                                        }

                                        // لو باقي 0 أو 1 -> قريبة
                                        if ($diffDays === 0 || $diffDays === 1) {
                                            $isNear = true;
                                        }
                                    }
                                @endphp

                                @if ($showRow)
                                    <tr class="{{ $isToday ? ' bg-danger text-white fw-bold' : '' }}">
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
                                        <td>{{ $duration->created_at?->format('Y-m-d') ?? '-' }}</td>
                                        <td>{{ Str::limit($duration->period_facts, 50, '...') }}</td>
                                        <td>{{ $duration->period_start ?? '-' }}</td>

                                        <td class="{{ $isNear && !$isToday ? 'text-white bg-danger fw-bold' : '' }}">
                                            {{ $endDateStr ?? ($duration->period_end ?? '-') }}
                                        </td>

                                        <td>{{ $case->client->name ?? '-' }}</td>
                                        <td>{{ $case->opponent_name ?? '-' }}</td>
                                        <td>{{ $case->court_name ?? '-' }}</td>
                                        <td>{{ Str::limit($duration->notes, 40, '...') ?? '-' }}</td>
                                        <td>{{ $duration->firstSubmitter->name ?? '-' }}</td>
                                        <td>{{ $duration->secondSubmitter->name ?? '-' }}</td>
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
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
                                    <th>إجراء</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notes as $note)
                                @php
                                    $case = $note->case;
                                    $showRow = false;
                                    $rowClass = '';

                                    if (!empty($note->period_end)) {
                                        $endDateObj = new DateTime($note->period_end, new DateTimeZone('Asia/Amman'));
                                        $todayObj = new DateTime('now', new DateTimeZone('Asia/Amman'));

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
                                        <td>{{ $note->created_at ? $note->created_at->format('Y-m-d') : '-' }}</td>
                                        <td>{{ Str::limit($note->period_facts, 50, '...') }}</td>
                                        <td>{{ $note->period_start ?? '-' }}</td>

                                        <td>
                                            {{ $endDateStr ?? ($note->period_end ?? '-') }}
                                        </td>

                                        <td>{{ $case->client->name ?? '-' }}</td>
                                        <td>{{ $case->opponent_name ?? '-' }}</td>
                                        <td>{{ $case->court_name ?? '-' }}</td>
                                        <td>{{ Str::limit($note->notes, 40, '...') ?? '-' }}</td>
                                        <td>{{ $note->firstSubmitter->name ?? '-' }}</td>
                                        <td>{{ $note->secondSubmitter->name ?? '-' }}</td>
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                            <td>
                                                <form action="{{ route('case.note.submit', $note) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check"></i> انجاز
                                                    </button>
                                                </form>
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

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
        <!-- المدد القانونية -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center gap-2">
                <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>المدد القانونية </h5>
                <span class="badge bg-primary fs-6 px-3 py-2">{{ $durations->count() }} مدة</span>
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
                            @foreach ($durations as $duration)
                                @php
                                    $case = $duration->case;

                                    // افتراض: نريد عرض الصف لو باقي عليه 6 أيام أو أقل
                                    $showRow = false;
                                    $isNear = false; // لون أحمر لو باقي يوم أو اليوم نفسه

                                    if (!empty($duration->period_end)) {
                                        // نطبع التاريخ بس بدون وقت علشان المقارنة تبقى صحيحة
                                        $endDateStr = date('Y-m-d', strtotime($duration->period_end));
                                        $todayStr = date('Y-m-d');
                                        $endTimestamp = strtotime($endDateStr);
                                        $todayTimestamp = strtotime($todayStr);

                                        // الفرق بالأيام (integer)
                                        $diffDays = (int) floor(($endTimestamp - $todayTimestamp) / 86400);

                                        // لو باقي 0..6 يوم -> نظهر الصف
                                        if ($diffDays >= 0 && $diffDays <= 6) {
                                            $showRow = true;
                                        }

                                        // لو باقي 0 أو 1 يوم -> نبينها كـ "قريبة" (أحمر)
                                        if ($diffDays === 0 || $diffDays === 1) {
                                            $isNear = true;
                                        }
                                    }
                                @endphp

                                @if ($showRow)
                                    <tr>
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

                                        {{-- طريقة آمنة لإضافة كلاس أو ستايل --}}
                                        <td class="{{ $isNear ? 'text-white bg-danger fw-bold' : '' }}"
                                            @if (!$isNear) {{-- لو ما نفعش الكلاسات تبقى نستخدم ستايل inline كاحتياط --}}
                style="" @endif>
                                            {{ $endDateStr ?? ($duration->period_end ?? '-') }}

                                            {{-- لو محتاج تتبع لماذا لا يعمل، فكّ كومنت السطر التالي عشان تشوف الفرق --}}
                                            {{-- <small class="d-block text-muted">diffDays: {{ $diffDays ?? 'N/A' }}</small> --}}
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
            <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center gap-2">
                <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>المذكرات القانونية </h5>
                <span class="badge bg-primary fs-6 px-3 py-2">{{ $notes->count() }} مذكره</span>
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
                            @foreach ($notes as $note)
                                @php
                                    $case = $note->case;
                                    $showRow = false;
                                    $isNear = false;

                                    if (!empty($note->period_end)) {
                                        $endDateStr = date('Y-m-d', strtotime($note->period_end));
                                        $todayStr = date('Y-m-d');
                                        $endTimestamp = strtotime($endDateStr);
                                        $todayTimestamp = strtotime($todayStr);

                                        $diffDays = (int) floor(($endTimestamp - $todayTimestamp) / 86400);

                                        // نظهر الصف لو باقي 0..6 أيام
                                        if ($diffDays >= 0 && $diffDays <= 6) {
                                            $showRow = true;
                                        }

                                        // نلون لو باقي يوم أو اليوم نفسه
                                        if ($diffDays === 0 || $diffDays === 1) {
                                            $isNear = true;
                                        }
                                    }
                                @endphp

                                @if ($showRow)
                                    <tr>
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
                                        <td>{{ $note->created_at?->format('Y-m-d') ?? '-' }}</td>
                                        <td>{{ Str::limit($note->period_facts, 50, '...') }}</td>
                                        <td>{{ $note->period_start ?? '-' }}</td>

                                        <td class="{{ $isNear ? 'text-white bg-danger fw-bold' : '' }}">
                                            {{ $endDateStr ?? ($note->period_end ?? '-') }}
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

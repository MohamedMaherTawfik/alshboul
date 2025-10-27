@extends('layouts.admin')
@section('title', 'بحث الجلسات')
@section('main_title_content', 'بحث الجلسات')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('cases.all') }}"> جميع القضايا</a>
@endsection

@section('content')
    <div class="card p-4 mb-4">
        <form action="{{ route('cases.search.find') }}" method="GET" class="row g-3">
            <!-- من تاريخ -->
            <div class="col-md-3">
                <label for="date_from" class="form-label">من تاريخ</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>

            <!-- إلى تاريخ -->
            <div class="col-md-3">
                <label for="date_to" class="form-label">إلى تاريخ</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>

            <!-- زر البحث -->
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">بحث</button>
            </div>
        </form>
    </div>

    <a href="{{ route('cases.search') }}" class="btn btn-dark mb-4">تصفية البحث</a>

    <div class="card p-4 shadow">
        <h3 class="mb-4 text-lg font-bold">
            نتائج البحث عن الجلسات من {{ request('date_from') }} إلى {{ request('date_to') }}
        </h3>

        @if (request()->routeIs('cases.search.find'))
            @php
                // فصل الجلسات حسب نوعها
                $normalCases = $sessions->filter(fn($s) => !is_null($s->cases_id));
                $executiveCases = $sessions->filter(fn($s) => !is_null($s->executive_case_id));
            @endphp

            {{-- 🟩 جدول القضايا العادية --}}
            @if ($normalCases->count() > 0)
                <h2 class="mt-3 mb-3 text-dark text-center">القضايا المنظوره</h2>
                <div class="table-responsive mb-5">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>المحامي</th>
                                <th>اسم القاضي</th>
                                <th>اسم المحكمة أو الدائرة</th>
                                <th>اسم المدخل</th>
                                <th>الملاحظات</th>
                                <th>تاريخ الجلسة</th>
                                <th>الوقائع</th>
                                <th>تاريخ الادخال</th>
                                <th>رقم الدعوي</th>
                                <th>رقم الملف</th>
                                <th>اسم الخصم</th>
                                <th>اسم الموكل</th>
                                <th>المستندات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($normalCases as $session)
                                <tr>

                                    <td>{{ $session->user->name ?? '-' }}</td>
                                    <td>{{ $session->cases?->jubge_name ?? 'بلا' }}</td>
                                    <td>{{ $session->cases->court_name ?? '-' }}</td>
                                    <td>{{ $session->userLawyer->name ?? '-' }}</td>
                                    <td>{{ $session->note ?? '-' }}</td>
                                    <td>{{ $session->date ?? '-' }}</td>
                                    <td>{{ $session->action ?? '-' }}</td>
                                    <td>{{ $session->created_at->format('d/m/Y') ?? '-' }}</td>
                                    <td>
                                        {{ $session->cases->file_number ?? '-' }}
                                        <a href="{{ route('cases.show', $session->cases) }}">
                                            <i class="fa fa-eye text-dark ms-1"></i>
                                        </a>
                                    </td>
                                    <td>{{ $session->cases->case_number ?? '-' }}</td>
                                    <td>
                                        @foreach ($session->cases->caseOpponents as $item)
                                            {{ $item->case_opponent_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>{{ $session->cases->subscriber->name ?? '-' }}</td>
                                    <td>
                                        @foreach ($files as $item)
                                            @if ($item->procedural_record_id == $session->id)
                                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-info">مستند</a>
                                            @endif
                                        @endforeach
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($executiveCases->count() > 0)
                <h2 class="mt-4 mb-3 text-dark text-6xl text-center">القضايا التنفيذية</h2>

                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead class="table-light">
                            <tr>
                                <th>المحامي</th>
                                <th>اسم المحكمة أو الدائرة</th>
                                <th>اسم المدخل</th>
                                <th>الملاحظات</th>
                                <th>تاريخ الجلسة</th>
                                <th>الوقائع</th>
                                <th>تاريخ الادخال</th>
                                <th>رقم الدعوي</th>
                                <th>رقم الملف</th>
                                <th>اسم الخصم</th>
                                <th>اسم الموكل</th>
                                <th>المستندات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($executiveCases as $session)
                                <tr>

                                    <td>{{ $session->user->name ?? '-' }}</td>
                                    <td>{{ $session->case->execution_court ?? '-' }}</td>
                                    <td>{{ $session->userLawyer->name ?? '-' }}</td>
                                    <td>{{ $session->note ?? '-' }}</td>
                                    <td>{{ $session->date ?? '-' }}</td>
                                    <td>{{ $session->action ?? '-' }}</td>
                                    <td>{{ $session->created_at->format('d/m/Y') ?? '-' }}</td>
                                    <td>
                                        {{ $session->case->case_number ?? '-' }}
                                        <a href="{{ route('procedural-record.index', $session->case) }}">
                                            <i class="fa fa-eye text-dark ms-1"></i>
                                        </a>
                                    </td>
                                    <td>{{ $session->case->file_number ?? '-' }}</td>
                                    <td>
                                        @foreach ($session->case->opponents as $item)
                                            {{ $item->case_opponent_name ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td>{{ $session->case->client->name ?? '-' }}</td>
                                    <td>
                                        @foreach ($files as $item)
                                            @if ($item->procedural_record_id == $session->id)
                                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-info">مستند</a>
                                            @endif
                                        @endforeach
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- 🔴 في حالة عدم وجود أي جلسات --}}
            @if ($normalCases->count() == 0 && $executiveCases->count() == 0)
                <div class="alert alert-warning mt-3">لا توجد جلسات في هذا التاريخ.</div>
            @endif
        @endif
    </div>
@endsection

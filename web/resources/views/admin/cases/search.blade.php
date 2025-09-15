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

            <!-- حقل التاريخ من -->
            <div class="col-md-3">
                <label for="date_from" class="form-label">من تاريخ</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>

            <!-- حقل التاريخ إلى -->
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
    <a href="{{ route('cases.search') }}"
        class="inline-block bg-[#000203FF] text-black px-4 py-2 rounded-lg hover:bg-green-700 transition">
        تصفية البحث
    </a>

    <div class="card p-4 shadow">
        <h3 class="mb-4 text-lg font-bold">
            نتائج البحث عن الجلسات من {{ request('date_from') }} إلى {{ request('date_to') }}
        </h3>

        @if (request()->routeIs('cases.search.find'))
            @if ($sessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>رقم الملف</th>
                                <th>رقم القضية</th>
                                <th>اسم القاضي </th>
                                <th>اسم المحكمة او الدائره</th>
                                <th>تاريخ الجلسة</th>
                                <th>الوقائع</th>
                                <th>المستندات</th>
                                <th>المحامي</th>
                                <th>الملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $index => $session)
                                <tr>
                                    @if ($session->cases)
                                        <td>{{ $session->cases->case_number ?? '-' }}</td>
                                    @elseif ($session->case)
                                        <td>{{ $session->case->file_number ?? '-' }}</td>
                                    @endif
                                    @if ($session->cases)
                                        <td>{{ $session->cases->file_number ?? '-' }}
                                        @elseif ($session->case)
                                        <td>{{ $session->case->case_number ?? '-' }}
                                    @endif
                                    @if ($session->cases)
                                        <a href="{{ route('cases.show', $session->cases) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @elseif ($session->case)
                                        <a href="{{ route('procedural-record.index', $session->case) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endif

                                    </td>
                                    <td>{{ $session->cases?->jubge_name ?? 'بلا' }}</td>
                                    @if ($session->cases)
                                        <td>{{ $session->cases->court_name ?? '-' }}</td>
                                    @else
                                        <td>{{ $session->case->execution_court ?? '-' }}</td>
                                    @endif
                                    <td>{{ $session->date ?? '-' }}</td>
                                    <td>{{ $session->action ?? '-' }}
                                    <td>
                                        @foreach ($files as $item)
                                            @if ($item->procedural_record_id == $session->id)
                                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                                    class="btn btn-sm btn-info">مستند</a>
                                            @endif
                                        @endforeach
                                    </td>
                                    @if ($session->cases)
                                        <td>{{ $session->user->name ?? '-' }}</td>
                                    @elseif ($session->case)
                                        <td>{{ $session->user->name ?? '-' }}</td>
                                    @endif
                                    <td>{{ $session->note ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning">لا توجد جلسات في هذا التاريخ.</div>
            @endif
        @endif
    </div>
@endsection

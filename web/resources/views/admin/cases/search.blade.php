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

            <!-- حقل التاريخ -->
            <div class="col-md-4">
                <label for="date" class="form-label">تاريخ الجلسة</label>
                <input type="date" name="date" id="date" class="form-control">
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
        <h3 class="mb-4 text-lg font-bold">نتائج البحث عن الجلسات بتاريخ {{ request('date') }}</h3>
        @if (request()->routeIs('cases.search.find'))
            @if ($sessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم القضية</th>
                                <th>اسم القاضي </th>
                                <th>اسم المحكمة</th>
                                <th>تاريخ الجلسة</th>
                                <th>الوقائع</th>
                                <th>المستندات</th>
                                <th>النوع</th>
                                <th>المحامي</th>
                                <th>الملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $index => $session)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $session->cases_id ?? '-' }}</td>
                                    <td>{{ $session->cases?->jubge_name ?? '-' }}</td>
                                    <td>{{ $session->cases_id ?? '-' }}</td>
                                    <td>{{ $session->date ?? '-' }}</td>
                                    <td>{{ $session->facts ?? '-' }}</td>
                                    <td>
                                        @if ($session->file)
                                            <a href="{{ asset('storage/' . $session->file) }}" target="_blank"
                                                class="btn btn-sm btn-info">عرض</a>
                                        @else
                                            لا يوجد
                                        @endif
                                    </td>
                                    <td>{{ $session->type ?? '-' }}</td>
                                    <td>{{ $session->lawyer->name ?? '-' }}</td>
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

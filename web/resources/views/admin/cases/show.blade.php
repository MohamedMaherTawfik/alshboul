@extends('layouts.admin')
@section('title', 'المصاريف')
@section('main_title_content', 'قائمة المصاريف')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('cases.all') }}"> جميع القضايا</a>
@endsection

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="m-0"><i class="fas fa-balance-scale me-2"></i>جلسات القضية</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>اسم الموكل</th>
                            <th>اسم المحكمة</th>
                            <th>تاريخ الجلسة</th>
                            <th>وقائع الدعوي</th>
                            <th>الملفات</th>
                            <th>رقم الدعوي</th>
                            <th>المحامي</th>
                            <th>اسم الخصم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($case->courtSession as $index => $session)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $case->client->name ?? '-' }}</td>
                                <td>{{ $case->court_name ?? '-' }}</td>
                                <td>{{ $session->date ?? '-' }}</td>
                                <td>{{ $session->facts ?? '-' }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $session->file) }}" target="_blank"
                                        class="btn btn-info">عرض</a>
                                </td>
                                <td>{{ $case->case_number ?? '-' }}</td>
                                <td>{{ $session->lawyer->name ?? '-' }}</td>
                                <td>{{ $case->opponent_name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">لا توجد جلسات مسجلة</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

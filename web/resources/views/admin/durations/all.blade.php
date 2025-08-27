@extends('layouts.admin')
@section('title', 'جميع المدد القانونيه')
@section('main_title_content', 'قائمة المدد القانونيه')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('duration.all') }}">جميع المدد</a>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <h5 class="mb-0">قائمة المدد القانونية</h5>
            <a href="{{ route('duration.all') }}" class="btn btn-dark btn-sm ms-auto mr-2">
                <i class="fas fa-list"></i> جميع المدد
            </a>
        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>رقم القضية</th>
                            <th>رقم الملف</th>
                            <th>اسم المدخل</th>
                            <th>تاريخ الإدخال</th>
                            <th>وقائع المدة</th>
                            <th>بداية المدة</th>
                            <th>نهاية المدة</th>
                            <th>اسم الموكل</th>
                            <th>اسم الخصم</th>
                            <th>اسم المحكمة</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($durations as $duration)
                            <tr>
                                <td>
                                    {{ $duration->case->file_number ?? '-' }}
                                    @if ($duration->case)
                                        <a href="{{ route('cases.show', $duration->case) }}" class="ms-2 text-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $duration->case->case_number ?? '-' }}</td>
                                <td>{{ $duration->user->name ?? '-' }}</td>
                                <td>{{ $duration->created_at?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ $duration->period_facts ?? '-' }}</td>
                                <td>{{ $duration->period_start ?? '-' }}</td>
                                <td>{{ $duration->period_end ?? '-' }}</td>
                                <td>{{ $duration->case->client->name ?? '-' }}</td>
                                <td>{{ $duration->case->opponent_name ?? '-' }}</td>
                                <td>{{ $duration->case->court_name ?? '-' }}</td>
                                <td>{{ $duration->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-muted">لا توجد مدد قانونية مسجلة</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

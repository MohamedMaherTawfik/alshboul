@extends('layouts.admin')
@section('title', 'جميع المذكرات القانونيه')
@section('main_title_content', 'قائمة المذكرات القانونيه')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('note.all') }}">جميع المذكرات</a>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <h5 class="mb-0">قائمة المذكرات القانونية</h5>
            <a href="{{ route('note.all') }}" class="btn btn-dark btn-sm ms-auto mr-2">
                <i class="fas fa-list"></i> جميع المذكرات
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
                        @forelse ($notes as $note)
                            <tr>
                                <td>{{ $note->case->case_number ?? '-' }}</td>
                                <td>{{ $note->case->file_number ?? '-' }}</td>
                                <td>{{ $note->user->name ?? '-' }}</td>
                                <td>{{ $note->created_at?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ $note->period_facts ?? '-' }}</td>
                                <td>{{ $note->period_start ?? '-' }}</td>
                                <td>{{ $note->period_end ?? '-' }}</td>
                                <td>{{ $note->case->client->name ?? '-' }}</td>
                                <td>{{ $note->case->opponent_name ?? '-' }}</td>
                                <td>{{ $note->case->court_name ?? '-' }}</td>
                                <td>{{ $note->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-muted">لا توجد مذكرات قانونية مسجلة</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

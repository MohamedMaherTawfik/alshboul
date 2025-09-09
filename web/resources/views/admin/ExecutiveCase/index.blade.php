@extends('layouts.admin')

@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'القضايا التنفيذية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('executive-case.index', $item) }}">قضايا تنفيذية</a>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">القضايا التنفيذية الخاصة بـ
                <span class="text-primary">{{ $item->name }}</span>
            </h4>
            <a href="{{ route('executive-case.create', $item->id) }}" class="btn btn-primary">
                + إضافة قضية تنفيذية لـ {{ $item->name }}
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th> اسم مشترك</th>
                                <th> اسم الموكل</th>
                                <th>الرقم الوطني </th>
                                <th>اسم الخصم</th>
                                <th>الرقم الوطني للخصم</th>
                                <th> رقم الدعوي</th>
                                <th> قيمه الدعوي</th>
                                <th>رقم الملف</th>
                                <th> الدائره</th>
                                <th> المحكوم له</th>
                                <th> المحكوم عليه</th>
                                <th>حالة الدعوي</th>
                                <th>نوع السند التنفيذي</th>
                                <th>رقم السند التنفيذي</th>
                                <th>تاريخ الجلسة الإجرائية</th>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <th>الاجراءات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($item->excutiveCases as $case)
                                <tr>
                                    <td>{{ $case->client?->name }}</td>
                                    <td>{{ $case->client_name }}</td>
                                    <td>{{ $case->client_national_id }}</td>
                                    <td>{{ $case->opponent_name }}</td>
                                    <td>{{ $case->opponent_national_id }}</td>
                                    <td>{{ $case->case_number }}</td>
                                    <td>{{ $case->case_value }}</td>
                                    <td>{{ $case->file_number }}</td>
                                    <td>{{ $case->execution_court }}</td>
                                    <td>{{ $case->judged_for_status }}</td>
                                    <td>{{ $case->judged_against_status }}</td>
                                    <td>{{ $case->case_status }}</td>
                                    <td>{{ $case->execution_document_type }}</td>
                                    <td>{{ $case->execution_document_number }}</td>
                                    <td>{{ $case->procedural_session_date }}</td>
                                    <td>
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                            <a href="{{ route('executive-case.edit', $case) }}"
                                                class="btn btn-warning btn-sm mb-1">✏️ تعديل</a>

                                            <form action="{{ route('executive-case.delete', $case) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mb-1"
                                                    onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                    🗑 حذف
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('procedural-record.index', $case) }}"
                                            class="btn btn-info btn-sm mb-1">⚖️ الإجراءات</a>

                                        <a href="{{ route('executive-case.settlement', $case) }}"
                                            class="btn btn-success btn-sm mb-1">➕ إضافة تسوية</a>

                                        <a href="{{ route('executive-case.expenses', $case) }}"
                                            class="btn btn-secondary btn-sm mb-1">💰 احتساب المصاريف</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="24" class="text-muted">لا توجد قضايا تنفيذية مضافة بعد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

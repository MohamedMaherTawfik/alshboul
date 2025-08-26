@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('cases.all') }}">جميع القضايا</a>
@endsection

<style>
    /* --- نفس التنسيقات اللي عندك بالظبط --- */
    .action-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .action-group .btn {
        min-width: 75px;
        text-align: center;
    }

    :root {
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --accent-color: #e74c3c;
        --light-bg: #f8f9fa;
        --border-color: #dee2e6;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7f9;
        color: #333;
    }

    .card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        padding: 1.2rem 1.5rem;
        font-weight: 600;
    }

    .table-responsive {
        border-radius: 0 0 12px 12px;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
        font-size: 0.9rem;
    }

    .table thead th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        padding: 1rem 0.75rem;
        border-bottom: none;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-color: var(--border-color);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .btn {
        font-size: 0.8rem;
        font-weight: 500;
        padding: 0.35rem 0.6rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-sm {
        min-width: 65px;
    }

    .btn-outline-primary {
        color: var(--secondary-color);
        border-color: var(--secondary-color);
    }

    .btn-outline-primary:hover {
        background-color: var(--secondary-color);
        color: white;
    }

    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }

    .btn-warning {
        background-color: #f39c12;
        border-color: #f39c12;
        color: white;
    }

    .btn-warning:hover {
        background-color: #e67e22;
        border-color: #e67e22;
    }

    .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }

    .btn-danger:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }

    .btn-success {
        background-color: #27ae60;
        border-color: #27ae60;
    }

    .btn-success:hover {
        background-color: #219653;
        border-color: #219653;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #138496;
    }

    .btn-dark {
        background-color: #343a40;
        border-color: #343a40;
    }

    .btn-dark:hover {
        background-color: #23272b;
        border-color: #23272b;
    }

    .status-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
    }

    .badge-active {
        background-color: rgba(46, 204, 113, 0.15);
        color: #27ae60;
    }

    .badge-upcoming {
        background-color: rgba(241, 196, 15, 0.15);
        color: #f39c12;
    }

    .badge-closed {
        background-color: rgba(108, 117, 125, 0.15);
        color: #6c757d;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #ced4da;
    }

    .dual-buttons {
        display: flex;
        gap: 0.3rem;
    }

    @media (max-width:768px) {
        .table thead {
            display: none;
        }

        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
        }

        .table tbody td {
            display: block;
            text-align: left;
            position: relative;
            padding-left: 50%;
        }

        .table tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 0.75rem;
            width: 45%;
            padding-right: 10px;
            font-weight: 600;
            text-align: right;
        }

        .table {
            width: 100% !important;
            table-layout: auto;
        }

        .table-responsive {
            width: 100% !important;
        }
    }
</style>

@section('content')
    <div class="container my-4">
        <div class="card shadow-lg border-0">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background: var(--primary-color); color: #fff;">
                <h5 class="m-0 flex-grow-1">
                    <i class="fas fa-balance-scale me-2"></i>جميع القضايا
                </h5>
                <a href="{{ route('casetypes.create.case') }}" class="btn btn-light btn-sm ms-auto">
                    <i class="fas fa-plus"></i> انشاء قضية جديدة
                </a>
            </div>


            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 text-center align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المدخل</th>
                                <th>الرقم الوطني للخصم</th>
                                <th>رقم الدعوي</th>
                                <th>قيمة الدعوي</th>
                                <th>اسم المحكمة</th>
                                <th>القاضي</th>
                                <th>تاريخ الجلسة القادمة</th>
                                <th>المستندات</th>
                                <th>وقائع الدعوي</th>
                                <th>المدة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cases as $case)
                                @php
                                    $lastSession = $case->courtSession->first(); // آخر جلسة
                                    $hoursLeft = null;
                                    if ($lastSession && !empty($lastSession->date)) {
                                        $hoursLeft = \Carbon\Carbon::now()->diffInHours(
                                            \Carbon\Carbon::parse($lastSession->date),
                                            false,
                                        );
                                    }
                                @endphp
                                <tr>
                                    <td data-label="#">{{ $loop->iteration }}</td>
                                    <td data-label="اسم المدخل">{{ $case->added_by->name }}</td>
                                    <td data-label="الرقم الوطني للخصم">{{ $case->opponent_national_id }}</td>
                                    <td data-label="رقم الدعوي">{{ $case->case_number }}</td>
                                    <td data-label="قيمة الدعوي">{{ $case->case_amount }}</td>
                                    <td data-label="اسم المحكمة">{{ $case->court_name }}</td>
                                    <td data-label="القاضي">{{ $case->jubge_name }}</td>

                                    <td data-label="تاريخ الجلسة القادمة"
                                        @if (!is_null($hoursLeft) && $hoursLeft <= 36 && $hoursLeft >= 0) style="color:white;background-color:red; font-weight:bold;min-width:200px;white-space:nowrap;"
    @else
        style="min-width:200px;white-space:nowrap;" @endif>
                                        {{ $lastSession->date ?? 'لا يوجد تاريخ' }}
                                    </td>


                                    <td data-label="المستندات">
                                        @if ($lastSession && !empty($lastSession->file))
                                            <a href="{{ asset('storage/' . $lastSession->file) }}" target="_blank"
                                                class="btn btn-sm btn-info">عرض المستندات</a>
                                        @else
                                            <span class="text-muted">لا يوجد مستندات</span>
                                        @endif
                                    </td>

                                    <td data-label="وقائع الدعوي">
                                        {{ $lastSession->facts ?? 'لا توجد وقائع' }}
                                    </td>

                                    <td data-label="المدة">
                                        <div class="dual-buttons">
                                            <a href="#" class="btn btn-sm btn-outline-primary">المدة</a>
                                            <a href="#" class="btn btn-sm btn-outline-secondary">المذكرات</a>
                                        </div>
                                    </td>

                                    <td data-label="الإجراءات">
                                        <div class="d-flex flex-column gap-2">
                                            <a href="{{ route('cases.edit', $case) }}"
                                                class="btn btn-sm btn-warning w-100">تعديل</a>
                                            <a href="{{ route('cases.show', $case) }}"
                                                class="btn btn-sm btn-primary w-100">الجلسات</a>
                                            <form action="{{ route('cases.destroy', $case) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من الحذف؟');" class="w-100">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger w-100">حذف</button>
                                            </form>
                                            <a href="{{ route('cases.add', $case) }}" class="btn btn-sm btn-success w-100">
                                                اضافه </a>
                                            <a href="{{ route('cases.settlement', $case) }}"
                                                class="btn btn-sm btn-info w-100">تسوية</a>
                                            <a href="{{ route('cases.expenses', $case) }}"
                                                class="btn btn-sm btn-dark w-100">المصاريف</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection

@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('cases.all') }}">
        جميع القضايا</a>
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
    <div class="container-fluid my-4">
        <div class="card shadow-lg border-0">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background: var(--primary-color); color: #fff; font-size: 1.4rem;">
                <h5 class="m-0 flex-grow-1" style="font-size: 1.6rem; font-weight: bold;">
                    جميع القضايا {{ $casetype->name }} : {{ count($casetype->suggestedCases) }}
                </h5>
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                    <a href="{{ route('casetypes.create.case', request('casetype')) }}" class="btn btn-light btn-lg ms-auto">
                        <i class="fas fa-plus"></i> انشاء قضية جديدة
                    </a>
                @endif
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">

                    {{-- ✅ صف البحث --}}
                    <div class="p-3 border-bottom" style="background-color: var(--primary-color);">
                        <div class="row g-2">
                            <div class="col-md-2">
                                <input type="text" id="search-subscriber" class="form-control border-0"
                                    placeholder="بحث باسم المشترك">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="search-client" class="form-control border-0"
                                    placeholder="بحث باسم الموكل">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="search-opponent" class="form-control border-0"
                                    placeholder="بحث باسم الخصم">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="search-case-number" class="form-control border-0"
                                    placeholder="بحث برقم الدعوي">
                            </div>
                            <div class="col-md-2">
                                <input type="text" id="search-court" class="form-control border-0"
                                    placeholder="بحث بالمحكمة">
                            </div>
                        </div>
                    </div>

                    <table id="cases-table" class="table table-striped table-hover mb-0 text-center align-middle"
                        style="font-size: 1.2rem; width: 100%;">
                        <thead style="font-size: 1.3rem; font-weight: bold;">
                            <tr>
                                <th>اسم المشترك</th>
                                <th>اسم الموكل</th>
                                <th>الرقم الوطني</th>
                                <th>اسم الخصم</th>
                                <th>الرقم الوطني للخصم</th>
                                <th>رقم الدعوي</th>
                                <th>قيمه الدعوي</th>
                                <th>رقم الملف</th>
                                <th>المحكمه</th>
                                <th>اسم القاضي</th>
                                <th>اخر نشاط</th>
                                <th>تاريخ الجلسة القادمة</th>
                                <th>الوقائع</th>
                                <th>وقائع الدعوي</th>
                                <th>المدة</th>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <th>الاجراءات</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody style="font-size: 1.2rem;">
                            @foreach ($cases as $case)
                                <tr>
                                    <td>{{ $case->subscriber->name ?? '-' }}</td>
                                    <td>{{ $case->client->name ?? '-' }}</td>
                                    <td>{{ $case->first_national_id ?? '-' }}</td>
                                    <td>
                                        @foreach ($case->caseOpponents as $item)
                                            {{ $item->case_opponent_name ?? '-' }} -
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($case->caseOpponents as $item)
                                            {{ $item->case_opponent_national_number }} -
                                        @endforeach
                                    </td>
                                    <td>{{ $case->file_number ?? '-' }}</td>
                                    <td>{{ $case->case_amount ?? '-' }}</td>
                                    <td>{{ $case->case_number ?? '-' }}</td>
                                    <td>{{ $case->court_name ?? '-' }}</td>
                                    <td>{{ $case->jubge_name ?? '-' }}</td>
                                    <td>{{ $case->proceduralRedords->last()?->created_at?->format('Y-m-d') ?? 'لا يوجد نشاط' }}
                                    </td>
                                    <td>
                                        @php
                                            $lastSession = $case->proceduralRedords->where('type', 'جلسه')->last();
                                        @endphp
                                        {{ $lastSession ? $lastSession->date : '-' }}
                                    </td>
                                    <td>{{ $case->proceduralRedords->last()->action ?? 'لا يوجد وقائع' }}</td>
                                    @if ($more == $case->id)
                                        <td><a href="{{ route('cases.show', $case) }}" class=""> تم
                                                تحويل القضيه اللي جميع التسويات
                                            </a></td>
                                    @else
                                        <td><a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-info">وقائع
                                                الدعوي</a></td>
                                    @endif

                                    <td>
                                        <div class="dual-buttons d-flex gap-2">
                                            <a href="{{ route('cases.show.durations', $case) }}"
                                                class="btn btn-lg btn-outline-primary flex-fill">المدد</a>
                                            <a href="{{ route('cases.show.notes', $case) }}"
                                                class="btn btn-lg btn-outline-secondary flex-fill">المذكرات</a>
                                        </div>
                                    </td>
                                    <td>
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                            <a href="{{ route('cases.edit', $case) }}"
                                                class="btn btn-lg btn-warning w-100">تعديل</a>
                                            <form action="{{ route('cases.destroy', $case) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من الحذف؟');" class="w-100">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-lg btn-danger w-100">حذف</button>
                                            </form>
                                            <div class="d-flex flex-column gap-2">
                                                <a href="{{ route('cases.settlement.all', $case) }}"
                                                    class="btn btn-lg btn-info w-100">+ تسويه</a>
                                                <a href="{{ route('cases.expenses', $case) }}"
                                                    class="btn btn-lg btn-dark w-100">المصاريف</a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ JavaScript live search --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = document.getElementById("cases-table").getElementsByTagName("tbody")[0];
            const filters = {
                subscriber: document.getElementById("search-subscriber"),
                client: document.getElementById("search-client"),
                opponent: document.getElementById("search-opponent"),
                caseNumber: document.getElementById("search-case-number"),
                court: document.getElementById("search-court"),
            };

            function filterTable() {
                const rows = table.getElementsByTagName("tr");
                const searchValues = {
                    subscriber: filters.subscriber.value.toLowerCase(),
                    client: filters.client.value.toLowerCase(),
                    opponent: filters.opponent.value.toLowerCase(),
                    caseNumber: filters.caseNumber.value.toLowerCase(),
                    court: filters.court.value.toLowerCase(),
                };

                for (let row of rows) {
                    const cells = row.getElementsByTagName("td");
                    let show = true;

                    if (searchValues.subscriber && !cells[0].innerText.toLowerCase().includes(searchValues
                            .subscriber)) show = false;
                    if (searchValues.client && !cells[1].innerText.toLowerCase().includes(searchValues.client))
                        show = false;
                    if (searchValues.opponent && !cells[3].innerText.toLowerCase().includes(searchValues.opponent))
                        show = false;
                    if (searchValues.caseNumber && !cells[5].innerText.toLowerCase().includes(searchValues
                            .caseNumber)) show = false;
                    if (searchValues.court && !cells[8].innerText.toLowerCase().includes(searchValues.court)) show =
                        false;

                    row.style.display = show ? "" : "none";
                }
            }

            Object.values(filters).forEach(input => {
                input.addEventListener("keyup", filterTable);
            });
        });
    </script>
@endsection

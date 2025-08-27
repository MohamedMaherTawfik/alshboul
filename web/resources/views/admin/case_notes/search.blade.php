@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('cases.all') }}">جميع القضايا</a>
@endsection

@section('content')
    <div class="container-fluid">

        <form action="{{ route('note.search.go') }}" method="GET" class="row g-2 align-items-center mb-4">

            <!-- من تاريخ -->
            <div class="col-auto d-flex align-items-center">
                <label for="from_date" class="me-2 mb-0 fw-bold text-dark" style="font-size: 0.85rem;">من: </label>
                <input type="date" name="from_date" id="from_date" class="form-control form-control-sm"
                    value="{{ request('from_date') }}">
            </div>

            <!-- إلى تاريخ -->
            <div class="col-auto d-flex align-items-center">
                <label for="to_date" class="me-2 mb-0 fw-bold text-dark" style="font-size: 0.85rem;">إلى: </label>
                <input type="date" name="to_date" id="to_date" class="form-control form-control-sm"
                    value="{{ request('to_date') }}">
            </div>

            <!-- زر البحث -->
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary">بحث</button>
                <a href="{{ route('duration.search') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
            </div>
        </form>

        @if (route('note.search.go') == request()->url())
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center gap-2">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>المذكرات القانونية </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive shadow-sm rounded">
                        <table class="table table-bordered table-hover align-middle table-striped mb-0">
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
                                @if ($notes->isEmpty())
                                    <tr>
                                        <td colspan="11" class="text-center text-muted py-5">
                                            <i class="bi bi-calendar-x" style="font-size: 2rem; opacity: 0.3;"></i>
                                            <p class="mt-2 mb-0">لا توجد مذكرات قانونية مسجلة</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($notes as $note)
                                        @php
                                            $endDate = \Carbon\Carbon::parse($note->period_end);
                                            $today = \Carbon\Carbon::today();
                                            $isOverdue = $endDate->lt($today);
                                            $rowClass = $isOverdue ? 'status-overdue' : '';
                                        @endphp
                                        <tr class="{{ $rowClass }}">
                                            <td>{{ $note->case->case_number ?? '-' }}</td>
                                            <td>{{ $note->case->file_number ?? '-' }}</td>
                                            <td>{{ $note->user->name ?? '-' }}</td>
                                            <td>{{ $note->created_at?->format('Y-m-d') ?? '-' }}</td>
                                            <td>{{ Str::limit($note->period_facts, 50, '...') }}</td>
                                            <td><span class="note-date">{{ $note->period_start ?? '-' }}</span></td>
                                            <td>
                                                <span class="note-date">{{ $note->period_end ?? '-' }}</span>
                                                @if (!$isOverdue)
                                                    @php $daysLeft = $today->diffInDays($endDate, false); @endphp
                                                    <br>
                                                    <small class="text-muted">
                                                        (متبقي {{ $daysLeft }} يوم{{ $daysLeft != 1 ? ' ' : '' }})
                                                    </small>
                                                @else
                                                    <br>
                                                    <small class="text-danger fw-bold">متأخر!</small>
                                                @endif
                                            </td>
                                            <td>{{ $note->case->client->name ?? '-' }}</td>
                                            <td>{{ $note->case->opponent_name ?? '-' }}</td>
                                            <td>{{ $note->case->court_name ?? '-' }}</td>
                                            <td>{{ Str::limit($note->notes, 40, '...') ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            {{-- قم بالبحث اولا --}}
            <div class="alert alert-info text-center">قم بالبحث اولا</div>
        @endif
    </div>
@endsection

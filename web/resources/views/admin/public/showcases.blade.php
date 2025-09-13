@extends('layouts.admin')

@section('title', 'البحث العام')
@section('main_title_content', 'البحث العام')
@section('title_content', 'البحث العام')

@section('content')
    <div class="container-fluid px-4 py-3">

        {{-- نموذج البحث --}}
        <div class="card shadow-sm mb-5 w-100">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="fas fa-search me-2"></i> نموذج البحث المتقدم</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('public.search.find') }}">
                    @csrf

                    <div class="row">
                        {{-- بحث المشترك --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">بحث المشترك</label>
                            <select name="client_id" class="form-select form-select-lg">
                                <option value="">اختر المشترك</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- بحث الخصم --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">بحث الخصم</label>
                            <select name="opponent_id" class="form-select form-select-lg">
                                <option value="">اختر الخصم</option>
                                @foreach ($opponents as $opponent)
                                    <option value="{{ $opponent->id }}">{{ $opponent->case_opponent_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        {{-- بحث القضية --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">بحث القضية</label>
                            <input type="text" name="case" class="form-control form-control-lg"
                                placeholder="ادخل رقم القضية">
                        </div>

                        {{-- بحث المحكمة --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">بحث المحكمة</label>
                            <input type="text" name="court" class="form-control form-control-lg"
                                placeholder="ادخل اسم المحكمة">
                        </div>
                    </div>

                    {{-- زرار البحث --}}
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-search me-2"></i> بحث
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- نتائج البحث الخاصة بالقضية --}}
        @if (isset($case) && request()->routeIs('public.search.find'))
            <div class="mt-5">

                {{-- بيانات القضية --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-balance-scale me-2"></i> بيانات القضية</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>رقم الملف:</strong> {{ $case->case_number }}</p>
                        <p><strong>رقم الدعوى:</strong> {{ $case->file_number }}</p>
                        <p><strong>المحكمة:</strong> {{ $case->court_name }}</p>
                        <p><strong>القاضي:</strong> {{ $case->jubge_name }}</p>
                    </div>
                </div>

                {{-- جلسات المحكمة --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> جلسات المحكمة</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle w-100 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>تاريخ الجلسه</th>
                                    <th>الوقائع</th>
                                    <th>المحامي</th>
                                    <th>اسم المدخل</th>
                                    <th>تاريخ الادخال</th>
                                    <th>ملاحظات</th>
                                    <th>الملف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($case->courtSession as $session)
                                    <tr>
                                        <td>{{ $session->date ?? '-' }}</td>
                                        <td>{{ $session->facts ?? '-' }}</td>
                                        <td>{{ $session->lawyer_user->name ?? 'بلا' }}</td>
                                        <td>{{ $session->user->name ?? '-' }}</td>
                                        <td>{{ $session->created_at ?? '-' }}</td>
                                        <td>{{ $session->note ?? '-' }}</td>
                                        <td>

                                            @foreach ($session->sessionFiles as $file)
                                                <a href="{{ asset('storage/' . $file->file) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-info mb-1">
                                                    عرض
                                                </a>
                                            @endforeach

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">لا توجد جلسات</td>
                                    </tr>
                                @endforelse
                            </tbody>


                        </table>
                    </div>
                </div>

                {{-- الفترات القانونية --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-hourglass-half me-2"></i> الفترات القانونية</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle w-100 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>بداية الفترة</th>
                                    <th>نهاية الفترة</th>
                                    <th>الوقائع</th>
                                    <th>ملاحظات</th>
                                    <th>الحالة</th>
                                    <th>المدخل الأول</th>
                                    <th>المدخل الثاني</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($case->legalPeriods as $period)
                                    <tr>
                                        <td>{{ $period->period_start ?? '-' }}</td>
                                        <td>{{ $period->period_end ?? '-' }}</td>
                                        <td>{{ $period->period_facts ?? '-' }}</td>
                                        <td>{{ $period->notes ?? '-' }}</td>
                                        <td>{{ $period->is_done ? 'منجز' : 'قيد التنفيذ' }}</td>
                                        <td>{{ $period->firstSubmitter->name ?? '-' }}</td>
                                        <td>{{ $period->secondSubmitter->name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">لا توجد فترات قانونية</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ملاحظات القضية --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i> ملاحظات القضية</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle w-100 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>بداية الفترة</th>
                                    <th>نهاية الفترة</th>
                                    <th>الوقائع</th>
                                    <th>ملاحظات</th>
                                    <th>الحالة</th>
                                    <th>المدخل الأول</th>
                                    <th>المدخل الثاني</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($case->caseNotes as $note)
                                    <tr>
                                        <td>{{ $note->period_start ?? '-' }}</td>
                                        <td>{{ $note->period_end ?? '-' }}</td>
                                        <td>{{ $note->period_facts ?? '-' }}</td>
                                        <td>{{ $note->note ?? '-' }}</td>
                                        <td>{{ $note->is_done ? 'منجز' : 'قيد التنفيذ' }}</td>
                                        <td>{{ $note->firstSubmitter->name ?? '-' }}</td>
                                        <td>{{ $note->secondSubmitter->name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">لا توجد ملاحظات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- السجلات الإجرائية --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i> السجلات الإجرائية</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle w-100 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>المحامي</th>
                                    <th>تاريخ الإدخال</th>
                                    <th>الوقائع</th>
                                    <th>ملاحظات</th>
                                    <th>الملفات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($case->proceduralRedords as $record)
                                    <tr>
                                        <td>{{ $record->userLawyer->name ?? '-' }}</td>
                                        <td>{{ $record->user->name ?? '-' }}</td>
                                        <td>{{ $record->created_at ?? '-' }}
                                        </td>
                                        <td>{{ $record->action ?? '-' }}</td>
                                        <td>{{ $record->note ?? '-' }}</td>
                                        <td>
                                            @foreach ($record->files as $file)
                                                <a href="{{ asset('storage/' . $file->file_path) }}"
                                                    class="btn btn-sm btn-info mb-1" target="_blank">
                                                    عرض المستند
                                                </a>
                                            @endforeach

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">لا توجد سجلات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        @endif

    </div>
@endsection

@section('styles')
    <style>
        .card {
            border-radius: 12px;
        }

        .card-header h5 {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .table thead th {
            vertical-align: middle;
            text-align: center;
        }

        .table td {
            text-align: center;
        }
    </style>
@endsection

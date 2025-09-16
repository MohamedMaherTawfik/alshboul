@extends('layouts.admin')

@section('title', 'البحث العام')
@section('main_title_content', 'البحث العام')
@section('title_content', 'البحث العام')

@section('content')
    <div class="container-fluid px-4 py-3">

        <x-search-form />

        {{-- نتائج البحث الخاصة بالموكل --}}
        @if (isset($client) && request()->routeIs('public.search.find'))
            <div class="mt-5">

                {{-- بيانات الموكل --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i> بيانات الموكل</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>الاسم:</strong> {{ $client->name }}</p>
                        <p><strong>الرقم الوطني:</strong> {{ $client->national_id ?? 'غير مسجل' }}</p>
                        <p><strong>الموبايل:</strong> {{ $client->phone ?? 'غير مسجل' }}</p>
                    </div>
                </div>

                {{-- القضايا --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-gavel me-2"></i> القضايا</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle w-100 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>رقم الدعوى</th>
                                    <th>اسم الخصم</th>
                                    <th>الرقم الوطني للخصم</th>
                                    <th>رقم الملف</th>
                                    <th>نوع القضية</th>
                                    <th>المحكمة</th>
                                    <th>المبلغ</th>
                                    <th>القاضي</th>
                                    <th>إجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($client->cases as $case)
                                    <tr>
                                        <td>{{ $case->file_number }}</td>
                                        <td>
                                            @foreach ($case->caseOpponents as $item)
                                                {{ $item->case_opponent_name ?? '-' }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($case->caseOpponents as $item)
                                                {{ $item->case_opponent_national_number }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $case->case_number }}</td>
                                        <td>{{ $case->suggestedCases->name ?? '-' }}</td>
                                        <td>{{ $case->court_name }}</td>
                                        <td>{{ $case->case_amount }}</td>
                                        <td>{{ $case->jubge_name }}</td>
                                        <td>
                                            <a href="{{ route('cases.show', $case->id) }}"
                                                class="btn btn-sm btn-outline-primary d-inline-flex align-items-center"
                                                title="عرض">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8
                                                                                                         0 8s3 5.5 8 5.5S16 8 16 8z" />
                                                    <path
                                                        d="M8 5.5a2.5 2.5 0 1 0
                                                                                                         0 5 2.5 2.5 0 0 0 0-5z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">لا توجد قضايا</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- القضايا التنفيذية --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-balance-scale me-2"></i> القضايا التنفيذية</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle w-100 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>رقم الملف</th>
                                    <th>رقم الدعوى</th>
                                    <th>الحالة</th>
                                    <th>القيمة</th>
                                    <th>الدائرة التنفيذية</th>
                                    <th>المحكوم له</th>
                                    <th>المحكوم عليه</th>
                                    <th>نوع السند</th>
                                    <th>رقم السند</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($client->executiveCases as $exe)
                                    <tr>
                                        <td>{{ $exe->file_number }}</td>
                                        <td>{{ $exe->case_number }}</td>
                                        <td>{{ $exe->case_status }}</td>
                                        <td>{{ $exe->case_value }}</td>
                                        <td>{{ $exe->execution_court }}</td>
                                        <td>{{ $exe->judged_for_status }}</td>
                                        <td>{{ $exe->judged_against_status }}</td>
                                        <td>{{ $exe->execution_document_type }}</td>
                                        <td>{{ $exe->execution_document_number }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">لا توجد قضايا تنفيذية</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- الإجراءات --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i> اجراءات الموكل</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle w-100 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>تاريخ الادخال</th>
                                    <th>المحامي</th>
                                    <th>نوع الاجراء</th>
                                    <th>الجهة</th>
                                    <th>الوقائع</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($client->clientProcedurals as $proc)
                                    <tr>
                                        <td>{{ $proc->user->name ?? '-' }}</td>
                                        <td>{{ $proc->created_at->format('Y-m-d') ?? '-' }}</td>
                                        <td>{{ $proc->lawyer->name ?? '-' }}</td>
                                        <td>{{ $proc->procedural ?? '-' }}</td>
                                        <td>{{ $proc->side ?? '-' }}</td>
                                        <td>{{ $proc->procedural_facts ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">لا توجد إجراءات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- المعاملات --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i> المعاملات</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle w-100 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>اسم المدخل</th>
                                    <th>رقم الملف</th>
                                    <th>اسم الموكل</th>
                                    <th>الوصف</th>
                                    <th>الدائرة المختصه</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($client->transactions as $trans)
                                    <tr>
                                        <td>{{ $trans->user->name }}</td>
                                        <td>{{ $trans->file_number }}</td>
                                        <td>{{ $trans->client_name }}</td>
                                        <td>{{ $trans->description }}</td>
                                        <td>{{ $trans->area_name }}</td>
                                        <td>{{ $trans->notes }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">لا توجد معاملات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- الأرشيف --}}
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-archive me-2"></i> الأرشيف</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle w-100 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>رقم الملف</th>
                                    <th>اسم القائمة الفرعية</th>
                                    <th>اسم المدخل</th>
                                    <th>ملاحظات</th>
                                    <th>حالة التفعيل</th>
                                    <th>الوقت</th>
                                    <th>الملف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($client->archives as $archive)
                                    <tr>
                                        <td>{{ $archive->file_number ?? '-' }}</td>
                                        <td>{{ $archive->archivesSubMenues->name ?? '-' }}</td>
                                        <td>{{ $archive->user->name ?? '-' }}</td>
                                        <td>{{ $archive->notes ?? '-' }}</td>
                                        <td>{{ $archive->active ? 'مفعل' : 'غير مفعل' }}</td>
                                        <td>{{ $archive->time ?? '-' }}</td>
                                        <td>
                                            @if ($archive->file)
                                                <a href="{{ asset('storage/' . $archive->file) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-info">
                                                    عرض الملف
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">لا يوجد أرشيف</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- المهمات
                <div class="card mb-4 shadow-sm border-0 w-100">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i> المهمات</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover align-middle w-100 mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>الوصف</th>
                                    <th>المحامي الأول</th>
                                    <th>المحامي الثاني</th>
                                    <th>الملف</th>
                                    <th>الموعد النهائي</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($client->missions as $mission)
                                    <tr>
                                        <td>{{ $mission->description ?? '-' }}</td>
                                        <td>{{ $mission->firstLawyer->name ?? '-' }}</td>
                                        <td>{{ $mission->secondLawyer->name ?? '-' }}</td>
                                        <td>
                                            @if ($mission->file)
                                                <a href="{{ asset('storage/' . $mission->file) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-info">
                                                    عرض الملف
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $mission->deadline ?? '-' }}</td>
                                        <td>{{ $mission->is_done ? 'منجز' : 'قيد التنفيذ' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">لا توجد مهمات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> --}}

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

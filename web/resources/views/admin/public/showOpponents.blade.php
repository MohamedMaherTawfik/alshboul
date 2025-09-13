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

        {{-- نتائج البحث الخاصة بالموكل --}}
        @if (isset($opponent) && request()->routeIs('public.search.find'))
            <div class="mt-5">
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

                                <tr>
                                    <td>{{ $opponent->case->file_number }}</td>
                                    <td>
                                        @foreach ($opponent->case->caseOpponents as $item)
                                            {{ $item->case_opponent_name ?? '-' }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($opponent->case->caseOpponents as $item)
                                            {{ $item->case_opponent_national_number }}<br>
                                        @endforeach
                                    </td>
                                    <td>{{ $opponent->case->case_number }}</td>
                                    <td>{{ $opponent->case->suggestedCases->name ?? '-' }}</td>
                                    <td>{{ $opponent->case->court_name }}</td>
                                    <td>{{ $opponent->case->case_amount }}</td>
                                    <td>{{ $opponent->case->jubge_name }}</td>
                                    <td>
                                        <a href="{{ route('cases.show', $opponent->case->id) }}"
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

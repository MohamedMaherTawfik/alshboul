@extends('layouts.admin')
@section('title', 'سجل القضية')
@section('main_title_content', 'سجل القضية')

@section('content')
    @php
        use Illuminate\Support\Str;
        use Carbon\Carbon;
    @endphp

    {{-- تنسيق مخصص لتقوية الحدود --}}
    <style>
        table.custom-bordered th,
        table.custom-bordered td {
            border: 2px solid #b5b5b5 !important;
        }

        table.custom-bordered {
            border: 2px solid #b5b5b5 !important;
        }

        thead.table-light th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>

    <div class="col-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pt-3 pb-2">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-journal-text me-2"></i>
                    سجل القضية رقم: {{ $case->case_number ?? '-' }}
                </h4>
            </div>
        </div>
    </div>

    {{-- جدول السجلات --}}
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">سجلات القضية</h5>

                @if ($case->caseRecords->isEmpty())
                    <div class="alert alert-info text-center mb-0">
                        لا توجد سجلات لهذه القضية حالياً.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table custom-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>رقم العملية</th>
                                    <th>اسم المستخدم</th>
                                    <th>النوع</th>
                                    <th>تاريخ العملية</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($case->caseRecords as $index => $record)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $record->user->name ?? '-' }}</td>
                                        <td>{{ $record->type ?? '-' }} {{ $record->user->name }}</td>
                                        <td>{{ Carbon::parse($record->created_at)->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

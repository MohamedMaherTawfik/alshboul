@extends('layouts.admin')

@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'التسويات')
{{-- @section('link_content')
    <a href="{{ route('executive-case.index', $executiveCase) }}">قضايا تنفيذية</a>
@endsection --}}

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>المستخدم</th>
                            <th>الموكل</th>
                            <th>رقم المشترك</th>
                            <th>اسم الموكل</th>
                            <th>الرقم الوطني للموكل</th>
                            <th>اسم الخصم</th>
                            <th>الرقم الوطني للخصم</th>
                            <th>رقم الملف المكتبي</th>
                            <th>رقم الدعوى</th>
                            <th>رقم الملف</th>
                            <th>نوع القضايا التنفيذية</th>
                            <th>حالة القضية</th>
                            <th>قيمة الدعوى</th>
                            <th>الدائرة التنفيذية</th>
                            <th>نوع السند التنفيذي</th>
                            <th>المحكوم له</th>
                            <th>المحكوم عليه</th>
                            <th>تاريخ التسجيل</th>
                            <th>رقم السند التنفيذي</th>
                            <th>صفة المحكوم له</th>
                            <th>صفة المحكوم عليه</th>
                            <th>تاريخ الجلسة الإجرائية</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $executiveCase->user?->name }}</td>
                            <td>{{ $executiveCase->client?->name }}</td>
                            <td>{{ $executiveCase->subscriber_number }}</td>
                            <td>{{ $executiveCase->client_name }}</td>
                            <td>{{ $executiveCase->client_national_id }}</td>
                            <td>{{ $executiveCase->opponent_name }}</td>
                            <td>{{ $executiveCase->opponent_national_id }}</td>
                            <td>{{ $executiveCase->office_file_number }}</td>
                            <td>{{ $executiveCase->case_number }}</td>
                            <td>{{ $executiveCase->file_number }}</td>
                            <td>{{ $executiveCase->case_type }}</td>
                            <td>{{ $executiveCase->case_status }}</td>
                            <td>{{ $executiveCase->case_value }}</td>
                            <td>{{ $executiveCase->execution_court }}</td>
                            <td>{{ $executiveCase->execution_document_type }}</td>
                            <td>{{ $executiveCase->judged_for }}</td>
                            <td>{{ $executiveCase->judged_against }}</td>
                            <td>{{ $executiveCase->registration_date }}</td>
                            <td>{{ $executiveCase->execution_document_number }}</td>
                            <td>{{ $executiveCase->judged_for_status }}</td>
                            <td>{{ $executiveCase->judged_against_status }}</td>
                            <td>{{ $executiveCase->procedural_session_date }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">قائمة التسويات</h4>
            <a href="{{ route('executive-case.settlement.create', $executiveCase) }}" class="btn btn-primary">
                إضافة تسوية
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th>نوع الدعوي</th>
                        <th>رقم الدعوي</th>
                        <th>الالتزام</th>
                        <th>الرقم الوطني للخصم</th>
                        <th>اسم الموكل</th>
                        <th>اسم الخصم</th>
                        <th>قيمه الدين</th>
                        <th>قيمه الدفعات</th>
                        <th>واقع الاقساط</th>
                        <th>ملاحظات </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($executiveCase->settlements as $settlement)
                        <tr class="text-center">
                            <td>{{ $executiveCase->case_type ?? '-' }}</td>
                            <td>{{ $executiveCase->case_number ?? '-' }}</td>
                            <td>{{ $settlement->obligation ?? '-' }}</td>
                            <td>{{ $settlement->opponent_national_id ?? '-' }}</td>
                            <td>{{ $settlement->client_name ?? '-' }}</td>
                            <td>{{ $settlement->opponent_name ?? '-' }}</td>
                            <td>{{ $settlement->amount ?? '-' }}</td>
                            <td>{{ $settlement->payment_value ?? '-' }}</td>
                            <td>{{ $settlement->payment_terms ?? '-' }}</td>
                            <td>{{ $settlement->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">لا توجد تسويات مسجلة</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

@endsection

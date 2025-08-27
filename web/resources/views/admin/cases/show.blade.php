@extends('layouts.admin')
@section('title', 'تفاصيل القضية')
@section('main_title_content', 'تفاصيل القضية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('cases.all') }}"> جميع القضايا</a>
@endsection

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="m-0"><i class="fas fa-balance-scale me-2"></i>تفاصيل القضية</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <tbody>
                    <tr>
                        <th>رقم الدعوى</th>
                        <td>{{ $case->case_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>رقم الملف</th>
                        <td>{{ $case->file_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>نوع القضية</th>
                        <td>{{ $case->case_type ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>اسم المحكمة</th>
                        <td>{{ $case->court_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>اسم الموكل</th>
                        <td>{{ $case->client->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>الأرقام القومية (الموكل)</th>
                        <td>
                            {{ $case->first_national_id ?? '-' }} |
                            {{ $case->second_national_id ?? '-' }} |
                            {{ $case->third_national_id ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>اسم الخصم</th>
                        <td>{{ $case->opponent_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>الرقم القومي للخصم</th>
                        <td>{{ $case->opponent_national_id ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>اسم القاضي</th>
                        <td>{{ $case->jubge_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>قيمة المطالبة</th>
                        <td>{{ $case->case_amount ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>تاريخ الاستحقاق</th>
                        <td>{{ $case->benefit_date ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>تفاصيل القضية</th>
                        <td>{{ $case->case_details ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>وصف الموكل</th>
                        <td>{{ $case->client_description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>معلومات عامة</th>
                        <td>{{ $case->general_information ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>معلومات خاصة</th>
                        <td>{{ $case->private_information ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

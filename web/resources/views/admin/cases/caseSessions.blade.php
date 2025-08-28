@extends('layouts.admin')
@section('title', 'تفاصيل القضية')
@section('main_title_content', 'تفاصيل القضية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('cases.all') }}"> جميع القضايا</a>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white fw-bold">
                تفاصيل القضية
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>رقم الملف</th>
                                <th>الموكل</th>
                                <th>الرقم القومي الأول</th>
                                <th>اسم الخصم</th>
                                <th>الرقم القومي للخصم</th>
                                <th>القضية المقترحة</th>
                                <th>نوع القضية</th>
                                <th>رقم الدعوي</th>
                                <th>المحكمة</th>
                                <th>قيمة القضية</th>
                                <th>تاريخ الاستفادة</th>
                                <th>اسم القاضي</th>
                                <th>تفاصيل القضية</th>
                                <th>وصف الموكل</th>
                                <th>معلومات عامة</th>
                                <th>معلومات خاصة</th>
                                <th>أضيف بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $case->case_number }}</td>
                                <td>{{ $case->client->name }}</td>
                                <td>{{ $case->first_national_id }}</td>
                                <td>{{ $case->opponent_name }}</td>
                                <td>{{ $case->opponent_national_id }}</td>
                                <td>{{ $case->suggestedCases->name }}</td>
                                <td>{{ $case->case_type }}</td>
                                <td>{{ $case->file_number }}</td>
                                <td>{{ $case->court_name }}</td>
                                <td>{{ $case->case_amount }}</td>
                                <td>{{ $case->benefit_date }}</td>
                                <td>{{ $case->jubge_name }}</td>
                                <td>{{ $case->case_details ?? '-' }}</td>
                                <td>{{ $case->client_description ?? '-' }}</td>
                                <td>{{ $case->general_information ?? '-' }}</td>
                                <td>{{ $case->private_information ?? '-' }}</td>
                                <td>{{ $case->added_by->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= جدول مواعيد الجلسات ================= --}}
    <h3 class="mt-5">مواعيد الجلسات</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>التاريخ</th>
                <th>النوع</th>
                <th>الوقائع</th>
                <th>الملف</th>
                <th>الملاحظات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($case->courtSession as $session)
                <tr>
                    <td>{{ $session->id }}</td>
                    <td>{{ $session->date }}</td>
                    <td>{{ $session->type }}</td>
                    <td>{{ $session->facts }}</td>
                    <td>
                        @if ($session->file)
                            <a href="{{ asset('storage/' . $session->file) }}" target="_blank">عرض الملف</a>
                        @else
                            لا يوجد
                        @endif
                    </td>
                    <td>{{ $session->note }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">لا توجد جلسات</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    </div>
@endsection

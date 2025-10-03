@extends('layouts.admin')
@section('title', 'تفاصيل القضية')
@section('main_title_content', 'تفاصيل القضية')
@section('title_content', 'عرض')


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
                                <th>الرقم الوطني الأول</th>
                                <th>اسم الخصم</th>
                                <th>الرقم الوطني للخصم</th>
                                <th>حاله القضيه </th>
                                <th>نوع القضية</th>
                                <th>رقم الدعوي</th>
                                <th>المحكمة</th>
                                <th>قيمة القضية</th>
                                <th>اسم القاضي</th>
                                <th>تفاصيل القضية</th>
                                <th>وصف الموكل</th>
                                <th>وصف الخصم</th>
                                <th>أضيف بواسطة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $case->case_number }}</td>
                                <td>{{ $case->client->name }}</td>
                                <td>{{ $case->first_national_id }}</td>
                                <td>
                                    @foreach ($case->caseOpponents as $item)
                                        {{ $item->case_opponent_name }} -
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($case->caseOpponents as $item)
                                        {{ $item->case_opponent_national_number }} -
                                    @endforeach
                                </td>
                                <td>{{ $case->suggestedCases->name }}</td>
                                <td>{{ $case->case_type }}</td>
                                <td>{{ $case->file_number }}</td>
                                <td>{{ $case->court_name }}</td>
                                <td>{{ $case->case_amount }}</td>
                                <td>{{ $case->jubge_name }}</td>
                                <td>{{ $case->case_details ?? '-' }}</td>
                                <td>{{ $case->client_description ?? '-' }}</td>
                                <td>
                                    @foreach ($case->caseOpponents as $item)
                                        {{ $item->case_opponent_description }} -
                                    @endforeach
                                </td>
                                <td>{{ $case->added_by->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">قائمة التسويات</h4>
            <a href="{{ route('cases.settlement', $case) }}" class="btn btn-primary">
                إضافة تسوية
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark text-center">
                    <tr>
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
                    @forelse ($settlements as $settlement)
                        <tr class="text-center">
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

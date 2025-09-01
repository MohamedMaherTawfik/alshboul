@extends('layouts.admin')
@section('title', 'تفاصيل القضية')
@section('main_title_content', 'تفاصيل القضية')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('cases.all') }}">
        جميع القضايا</a>
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

    {{-- ================= جدول مواعيد الجلسات ================= --}}
    <div class="card-header bg-white border-0 pt-3 pb-2 d-flex flex-wrap align-items-center gap-2">
        <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i> مواعيد الجلسات </h5>
        <a href="{{ route('cases.add', $case) }}" class="btn btn-warning me-2 btn-sm ms-auto px-3 text-white">
            <i class="bi bi-list me-1"></i> اضافه جلسه
        </a>
    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>التاريخ</th>
                <th>النوع</th>
                <th>الوقائع</th>
                <th>الملف</th>
                <th>الملاحظات</th>
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                    <th>الاجراءات</th>
                @endif
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
                            <a href="{{ asset('storage/' . $session->file) }}" target="_blank" class="btn btn-sm btn-info">
                                عرض الملف
                            </a>
                        @else
                            لا يوجد
                        @endif
                        @foreach ($session->sessionFiles as $item)
                            <a href="{{ asset('storage/' . $item->file) }}" class="btn btn-sm btn-info" target="_blank">عرض
                                المستند</a>
                        @endforeach
                        <!-- زرار فتح المودال -->
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#uploadFileModal{{ $session->id }}">
                            إضافة ملف
                        </button>

                        <!-- المودال -->
                        <div class="modal fade" id="uploadFileModal{{ $session->id }}" tabindex="-1"
                            aria-labelledby="uploadFileModalLabel{{ $session->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('sessions.uploadFile', $session->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="uploadFileModalLabel{{ $session->id }}">رفع ملف
                                                للجلسة</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="file" class="form-label">اختر الملف</label>
                                                <input type="file" name="files[]" id="file" class="form-control"
                                                    multiple required>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-primary">رفع</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>{{ $session->note }}</td>
                    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                        <td>
                            <a href="{{ route('cases.session.edit', $session) }}" class="btn btn-primary btn-sm"><i
                                    class="bi bi-pencil-square"></i>تعديل</a>
                            <form action="{{ route('cases.session.delete', $session) }}" method="POST"
                                style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i>حذف</button>
                            </form>
                        </td>
                    @endif
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

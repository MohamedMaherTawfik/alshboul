@extends('layouts.admin')
@section('title', ' تفاصيل السجل الإجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'عرض')
{{-- @section('link_content')
    <a href="{{ route('procedural-record.index') }}">السجلات الجرائية </a>
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
    <div class="container-fluid">
        <!-- جدول الإجراءات -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">الإجراءات</h4>
            <a href="{{ route('procedural-record.create', $executiveCase) }}" class="btn btn-primary">
                انشاء اجراء
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>رقم الاجراء</th>
                        <th>انشاء بواسطه</th>
                        <th>النوع</th>
                        <th>الإجراء</th>
                        <th>المستندات</th>
                        <th>ملاحظة</th>
                        <th>المحامي</th>
                        <th>الإجراء التالي</th>
                        <th>تاريخ الإجراء التالي</th>
                        <th> اجراء فرعي </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($executiveCase->proceduralRecords as $record)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $record->creator?->name ?? '-' }}</td>
                            <td>{{ $record->type }}</td>
                            <td>{{ $record->action }}</td>
                            <td>
                                @foreach ($record->files as $item)
                                    <a href="{{ asset('storage/' . $item->file_path) }} " class="btn btn-sm btn-primary"
                                        target="_blank">مستند</a>
                                @endforeach
                                <!-- زرار -->
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#addFileModal-{{ $record->id }}">
                                    +
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="addFileModal-{{ $record->id }}" tabindex="-1"
                                    aria-labelledby="addFileModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('executive-case.add.file', $record) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addFileModalLabel">إضافة ملفات جديدة
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="إغلاق"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="file_path" class="form-label">اختر الملفات</label>
                                                        <input type="file" name="file_path[]" id="file_path"
                                                            class="form-control" multiple required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">إلغاء</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $record->note }}</td>
                            <td>{{ $record->user->name ?? '-' }}</td>
                            <td>{{ $record->next_action }}</td>
                            <td>{{ $record->next_action_date }}</td>
                            <td><a href="{{ route('executive-case.procedural.show', $executiveCase) }}"
                                    class="btn btn-primary">اجراء فرعي</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد إجراءات مسجلة</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

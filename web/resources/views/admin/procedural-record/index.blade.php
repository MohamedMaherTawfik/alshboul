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
                            <th>المشترك</th>
                            <th>رقم المشترك</th>
                            <th>اسم الموكل</th>
                            <th>الرقم الوطني للموكل</th>
                            <th>اسم الخصم</th>
                            <th>الرقم الوطني للخصم</th>
                            <th>رقم الدعوى</th>
                            <th>رقم الملف</th>
                            <th>نوع القضايا التنفيذية</th>
                            <th>حالة القضية</th>
                            <th>قيمة الدعوى</th>
                            <th>الدائرة التنفيذية</th>
                            <th>نوع السند التنفيذي</th>
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
                            <td>{{ $executiveCase->case_number }}</td>
                            <td>{{ $executiveCase->file_number }}</td>
                            <td>{{ $executiveCase->case_type }}</td>
                            <td>{{ $executiveCase->case_status }}</td>
                            <td>{{ $executiveCase->case_value }}</td>
                            <td>{{ $executiveCase->execution_court }}</td>
                            <td>{{ $executiveCase->execution_document_type }}</td>
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
        <!-- العنوان وزرار إنشاء إجراء -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">الإجراءات</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProceduralModal">
                انشاء اجراء
            </button>
        </div>

        <!-- Modal إنشاء إجراء -->
        <div class="modal fade" id="createProceduralModal" tabindex="-1" aria-labelledby="createProceduralModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('procedural-record.store', $executiveCase) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createProceduralModalLabel">إنشاء إجراء جديد</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                        </div>
                        <div class="modal-body row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">النوع</label>
                                <input type="text" name="type" class="form-control" value="اجراء" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">الإجراء</label>
                                <input type="text" name="action" class="form-control" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">ملاحظات</label>
                                <textarea name="note" class="form-control"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">المحامي</label>
                                <select name="user_id" class="form-select">
                                    <option value="">-- اختر المحامي --</option>
                                    @foreach ($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">رفع مستندات</label>
                                <input type="file" name="files[]" class="form-control" multiple>
                                <small class="text-muted">يمكنك اختيار أكثر من ملف</small>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
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
                        <th> اجراء فرعي </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($executiveCase->proceduralRecords as $record)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $record->created_by ?? '-' }}</td>
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
                            <td><a href="{{ route('executive-case.procedural.show', $executiveCase) }}"
                                    class="btn btn-primary">اجراء فرعي</a>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <a href="{{ route('procedural-record.edit', $record) }}"
                                        class="btn btn-success">تعديل</a>
                                    {{-- <form action="{{ route('procedural-record.delete', $record) }}" method="POST"
                                        class="d-inline p-2" onsubmit="return confirm('هل انت متأكد من الحذف؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            حذف
                                        </button>
                                    </form> --}}
                                @endif
                            </td>
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

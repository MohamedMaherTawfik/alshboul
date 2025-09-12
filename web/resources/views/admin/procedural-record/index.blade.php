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
                            <th> اسم مشترك</th>
                            <th> اسم الموكل</th>
                            <th>الرقم الوطني </th>
                            <th>اسم الخصم</th>
                            <th>الرقم الوطني للخصم</th>
                            <th> رقم الدعوي</th>
                            <th> قيمه الدعوي</th>
                            <th>رقم الملف</th>
                            <th> الدائره</th>
                            <th> المحكوم له</th>
                            <th> المحكوم عليه</th>
                            <th>حالة الدعوي</th>
                            <th>نوع السند التنفيذي</th>
                            <th>رقم السند التنفيذي</th>
                            <th>تاريخ الجلسة الإجرائية</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $executiveCase->client?->name }}</td>
                            <td>{{ $executiveCase->client_name }}</td>
                            <td>{{ $executiveCase->client_national_id }}</td>
                            <td>{{ $executiveCase->opponent_name }}</td>
                            <td>{{ $executiveCase->opponent_national_id }}</td>
                            <td>{{ $executiveCase->case_number }}</td>
                            <td>{{ $executiveCase->case_value }}</td>
                            <td>{{ $executiveCase->file_number }}</td>
                            <td>{{ $executiveCase->execution_court }}</td>
                            <td>{{ $executiveCase->judged_for_status }}</td>
                            <td>{{ $executiveCase->judged_against_status }}</td>
                            <td>{{ $executiveCase->case_status }}</td>
                            <td>{{ $executiveCase->execution_document_type }}</td>
                            <td>{{ $executiveCase->execution_document_number }}</td>
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
                            <h5 class="modal-title" id="createProceduralModalLabel">
                                <i class="bi bi-gear-fill me-2"></i> إنشاء إجراء جديد
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                        </div>

                        <div class="modal-body row">

                            <!-- النوع -->

                            <input type="hidden" name="type" class="form-control" value="إجراء" readonly>


                            <!-- تاريخ الإجراء -->
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label required-field">تاريخ الإجراء</label>
                                <input type="date" class="form-control" id="date" name="date">
                            </div>

                            <!-- تاريخ الإدخال -->
                            <div class="col-md-6 mb-3">
                                <label for="created_at" class="form-label required-field">تاريخ الإدخال</label>
                                <input type="date" class="form-control" id="created_at" name="created_at"
                                    value="{{ old('created_at', now()->format('Y-m-d')) }}">
                            </div>

                            <!-- المحامي -->
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label required-field">المحامي</label>
                                <select name="user_id" id="user_id" class="form-select">
                                    <option value="" selected disabled>-- اختر المحامي --</option>
                                    @foreach ($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- وقائع / تفاصيل الإجراء -->
                            <div class="col-md-12 mb-3">
                                <label for="action" class="form-label required-field">تفاصيل الإجراء</label>
                                <textarea class="form-control" id="action" name="action" rows="4" required
                                    placeholder="أدخل تفاصيل الإجراء..."></textarea>
                            </div>

                            <!-- ملاحظات -->
                            <div class="col-md-12 mb-3">
                                <label for="note" class="form-label">ملاحظات</label>
                                <textarea class="form-control" id="note" name="note" rows="3" placeholder="أدخل أي ملاحظات إضافية..."></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="next_action" class="form-label">اجراء قادم</label>
                                <input type="text" class="form-control" id="next_action" name="next_action">
                            </div>

                            <!-- تاريخ الإجراء -->
                            <div class="col-md-6 mb-3">
                                <label for="next_action_date" class="form-label required-field">تاريخ الإجراء القادم</label>
                                <input type="date" class="form-control" id="next_action_date" name="next_action_date">
                            </div>

                            <!-- رفع الملفات -->
                            <div class="col-md-12 mb-3">
                                <label for="files" class="form-label">رفع مستندات</label>
                                <input type="file" name="files[]" id="files" class="form-control" multiple>
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
                        <th> اسم المدحل</th>
                        <th>النوع</th>
                        <th>الإجراء</th>
                        <th>المستندات</th>
                        <th>تاريخ الادخال</th>
                        <th>ملاحظة</th>
                        <th>المحامي</th>
                        <th>اجراء قادم</th>
                        <th>تاريخ الاجراء القادم</th>
                        <th> اجراء فرعي </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($executiveCase->proceduralRecords as $record)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $record->userLawyer?->name ?? '-' }}</td>
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
                            <td>{{ date('Y-m-d H:i', strtotime($record->created_at->setTimezone('Asia/Amman'))) }}</td>
                            <td>{{ $record->note }}</td>
                            <td>{{ $record->user->name ?? '-' }}</td>
                            <td>{{ $record->next_action ?? '-' }}</td>
                            <td>{{ $record->next_action_date ?? '-' }}</td>
                            <td><a href="{{ route('executive-case.procedural.show', $record) }}"
                                    class="btn btn-primary">اجراء فرعي</a>
                                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                                    <a href="{{ route('procedural-record.edit', $record) }}"
                                        class="btn btn-success">تعديل</a>
                                    <form action="{{ route('procedural-record.delete', $record) }}" method="POST"
                                        class="d-inline p-2" onsubmit="return confirm('هل انت متأكد من الحذف؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            حذف
                                        </button>
                                    </form>
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

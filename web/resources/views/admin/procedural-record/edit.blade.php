@extends('layouts.admin')

@section('title', 'تعديل السجل الإجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="#">السجلات الإجرائية</a>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>تعديل الإجراء</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('procedural-record.update', $executiveCase) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="type" value="إجراء" readonly>

                            <div class="row">
                                <!-- تاريخ الجلسة -->
                                <div class="col-md-6 mb-3">
                                    <label for="date" class="form-label required-field">تاريخ الجلسة</label>
                                    <input type="date" class="form-control" id="date" name="date"
                                        value="{{ $executiveCase->date }}">
                                </div>

                                <!-- تاريخ الإدخال -->
                                <div class="col-md-6 mb-3">
                                    <label for="created_at" class="form-label required-field">تاريخ الإدخال</label>
                                    <input type="date" class="form-control" id="created_at" name="created_at"
                                        value="{{ \Carbon\Carbon::parse($executiveCase->created_at)->format('Y-m-d') }}">
                                </div>

                                <!-- الإجراء القادم -->
                                <div class="col-md-6 mb-3">
                                    <label for="next_action" class="form-label">الإجراء القادم</label>
                                    <input type="text" class="form-control" id="next_action" name="next_action"
                                        value="{{ $executiveCase->next_action }}">
                                </div>

                                <!-- تاريخ الإجراء القادم -->
                                <div class="col-md-6 mb-3">
                                    <label for="next_action_date" class="form-label">تاريخ الإجراء القادم</label>
                                    <input type="date" class="form-control" id="next_action_date" name="next_action_date"
                                        value="{{ $executiveCase->next_action_date }}">
                                </div>
                            </div>

                            <!-- المحامي -->
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label required-field">المحامي</label>
                                <select name="user_id" id="user_id" class="form-select" required>
                                    <option value="{{ $executiveCase->user_id }}" selected>
                                        {{ $executiveCase->user->name ?? '---' }}
                                    </option>
                                    @foreach ($lawyers as $user)
                                        @if ($user->id != $executiveCase->user_id)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <!-- تفاصيل الإجراء -->
                            <div class="mb-3">
                                <label for="action" class="form-label required-field">تفاصيل الإجراء</label>
                                <textarea class="form-control" id="action" name="action" rows="4" required>{{ $executiveCase->action }}</textarea>
                            </div>

                            <!-- ملاحظات -->
                            <div class="mb-3">
                                <label for="note" class="form-label">ملاحظات</label>
                                <textarea class="form-control" id="note" name="note" rows="3">{{ $executiveCase->note }}</textarea>
                            </div>

                            <!-- الملفات الحالية -->
                            @if ($executiveCase->files->count() > 0)
                                <div class="mb-4">
                                    <p class="fw-bold">الملفات الحالية:</p>
                                    <ul class="list-group">
                                        @foreach ($executiveCase->files as $file)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">عرض
                                                    الملف</a>
                                                <form
                                                    action="{{ route('procedural-executiveCase.file.destroy', $file->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا الملف؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4">تحديث</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

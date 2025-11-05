@extends('layouts.admin')

@section('title', 'تعديل سجل إجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('procedural-record.index', $case) }}">السجلات الإجرائية</a>
@endsection

<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --accent-color: #e74c3c;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        border: none;
    }

    .card-header {
        background-color: var(--primary-color);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }

    .btn-primary {
        background-color: var(--secondary-color);
        border: none;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    .btn-warning {
        background-color: #f39c12;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e67e22;
    }

    .required-field::after {
        content: " *";
        color: var(--accent-color);
    }

    .form-label {
        font-weight: 500;
    }

    .page-title {
        color: var(--primary-color);
        border-right: 4px solid var(--secondary-color);
        padding-right: 15px;
    }
</style>

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <h2 class="page-title">تعديل سجل إجرائي</h2>
                <p class="text-muted">قم بتعديل بيانات السجل الإجرائي الخاص بالقضية</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-3">
                <h5 class="card-title mb-0"><i class="bi bi-pencil-square me-2"></i>نموذج تعديل الإجراء</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('cases.mainprocedure.update', $case) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- نوع الإجراء -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="type" class="form-label required-field">نوع الإجراء</label>
                            <input type="text" name="type" id="type" class="form-control"
                                value="{{ old('type', $case->type) }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="date" class="form-label required-field">تاريخ الجلسة</label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ old('date', $case->date) }}">
                        </div>
                    </div>

                    <!-- نوع الإجراء -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="type" class="form-label required-field"> الإجراء القادم</label>
                            <input type="text" name="next_action" id="type" class="form-control"
                                value="{{ $case->next_action }}">
                        </div>

                        <div class="col-md-6">
                            <label for="date" class="form-label required-field">تاريخ الاجراء القادم</label>
                            <input type="date" name="next_action_date" id="date" class="form-control"
                                value="{{ $case->next_action_date }}">
                        </div>
                    </div>

                    <!-- تفاصيل الإجراء -->
                    <div class="mb-3">
                        <label for="action" class="form-label required-field">تفاصيل الإجراء</label>
                        <input type="text" name="action" id="action" class="form-control"
                            value="{{ old('action', $case->action) }}" placeholder="أدخل تفاصيل الإجراء...">

                    </div>

                    <div class="col-md-6">
                        <label for="date" class="form-label required-field">تاريخ الادخال</label>
                        <input type="datetime-local" class="form-control" id="created_at" name="created_at"
                            value="{{ old('created_at', now()->format('Y-m-d\TH:i')) }}">
                    </div>

                    <!-- الملاحظات -->
                    <div class="mb-3">
                        <label for="note" class="form-label">ملاحظات</label>
                        <textarea name="note" id="note" class="form-control" rows="3" placeholder="أدخل ملاحظات إضافية...">{{ old('note', $case->note) }}</textarea>
                    </div>

                    <!-- المحامي -->
                    <div class="mb-4">
                        <label for="user_id" class="form-label required-field">المحامي المسؤول</label>
                        <select name="user_id" id="user_id" class="form-select">
                            <option value="">اختر المحامي</option>
                            @foreach ($lawyers as $lawyer)
                                <option value="{{ $lawyer->id }}"
                                    {{ old('user_id', $case->user_id) == $lawyer->id ? 'selected' : '' }}>
                                    {{ $lawyer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- الأزرار -->
                    <div class="d-flex justify-content-end gap-2">
                        {{-- <a href="{{ url()->previous() }}" class="btn btn-secondary">إلغاء</a> --}}
                        <button type="submit" class="btn btn-warning">تحديث</button>
                    </div>
                </form>
                @if ($case->files && $case->files->count())
                    <div class="mb-4">
                        <h6 class="fw-bold"><i class="bi bi-file-earmark-text me-2"></i>الملفات الحالية:</h6>
                        <ul class="list-group">
                            @foreach ($case->files as $file)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">عرض
                                        المستند</a>
                                    <form action="{{ route('cases.procedure.file.delete', $file->id) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا الملف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

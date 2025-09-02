@extends('layouts.admin')

@section('title', 'تعديل سجل إجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('procedural-record.index', $case) }}">السجلات الجرائية </a>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark text-center">
                        <h4>تعديل الإجراء</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cases.procedure.update', $case) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- نوع الإجراء -->
                            <div class="mb-3">
                                <label for="type" class="form-label">نوع الإجراء</label>
                                <input type="text" name="type" id="type" class="form-control"
                                    value="{{ old('type', $case->type) }}">
                            </div>

                            <!-- الإجراء -->
                            <div class="mb-3">
                                <label for="action" class="form-label">الإجراء</label>
                                <input type="text" name="action" id="action" class="form-control"
                                    value="{{ old('action', $case->action) }}">
                            </div>

                            <!-- رفع الملفات -->
                            <div class="mb-3">
                                @if ($case->files && count($case->files))
                                    <div class="mt-2">
                                        <p>الملفات الحالية:</p>
                                        <ul>
                                            @if ($case->file)
                                                <a href="{{ asset('storage/' . $case->file) }}"
                                                    class="text-primary btn btn-sm"></a>
                                            @endif
                                            @foreach ($case->files as $file)
                                                <li>
                                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                        class="text-primary btn btn-sm">
                                                        عرض الملف
                                                    </a>
                                                    <a href="{{ route('cases.procedure.file.delete', $file) }}"
                                                        class="text-danger btn btn-sm">
                                                        حذف
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <p class="btn btn-info">لا يوجد ملفات</p>
                                @endif
                            </div>

                            <!-- ملاحظة -->
                            <div class="mb-3">
                                <label for="note" class="form-label">ملاحظة</label>
                                <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', $case->note) }}</textarea>
                            </div>

                            <!-- المحامي -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label">المحامي</label>
                                <input type="text" name="user_id" value="{{ $case->user->name }}" class="form-control"
                                    readonly>
                                <input type="hidden" name="user_id" value="{{ $case->user->id }}">
                            </div>

                            <!-- زر التحديث -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning">تحديث</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

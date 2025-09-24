@extends('layouts.admin')

@section('title', 'إضافة سجل إجرائي جديد')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('procedural-record.index', $settlement) }}">السجلات الجرائية</a>
@endsection

@section('content')
    <div class="container my-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-dark text-white text-center fw-bold">
                إضافة سجل إجرائي جديد
            </div>
            <div class="card-body p-4">
                <form action="{{ route('settlements.procedure.store', $settlement) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">

                        <!-- نوع الإجراء -->
                        <div class="col-md-6">
                            <label for="type" class="form-label fw-bold">نوع الإجراء</label>
                            <input type="text" name="type" id="type" class="form-control">
                        </div>

                        <!-- تاريخ الإجراء -->
                        <div class="col-md-6">
                            <label for="date" class="form-label fw-bold">تاريخ الإجراء</label>
                            <input type="date" name="date" id="date" class="form-control"
                                value="{{ old('date', now()->toDateString()) }}">
                        </div>

                        <!-- الإجراء -->
                        <div class="col-12">
                            <label for="action" class="form-label fw-bold">الإجراء</label>
                            <input type="text" name="action" id="action" class="form-control">
                        </div>

                        <!-- الملاحظات -->
                        <div class="col-12">
                            <label for="note" class="form-label fw-bold">ملاحظات</label>
                            <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- رفع الملفات -->
                        <div class="col-12">
                            <label for="file_path" class="form-label fw-bold">المستندات</label>
                            <input type="file" name="file_path[]" id="file_path" class="form-control" multiple>
                            <small class="text-muted">يمكنك رفع أكثر من ملف</small>
                        </div>

                        <!-- المحامي -->
                        <div class="col-12">
                            <label for="user_id" class="form-label fw-bold">المحامي</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">اختر المحامي</option>
                                @foreach ($lawyers as $lawyer)
                                    <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- زر الحفظ -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('procedural-record.index', $settlement) }}" class="btn btn-secondary">رجوع</a>
                        <button type="submit" class="btn btn-success px-4">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

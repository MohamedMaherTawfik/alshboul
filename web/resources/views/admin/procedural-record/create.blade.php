@extends('layouts.admin')

@section('title', 'إضافة سجل إجرائي جديد')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('procedural-record.index', $executiveCase) }}">السجلات الجرائية </a>
@endsection
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>إضافة إجراء جديد</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('procedural-record.store', $executiveCase) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- نوع الإجراء -->
                            <div class="mb-3">
                                <label for="type" class="form-label">نوع الإجراء</label>
                                <input type="text" name="type" id="type" class="form-control">
                            </div>

                            <!-- نوع الإجراء -->
                            <div class="mb-3">
                                <label for="date" class="form-label">تاريخ الإجراء</label>
                                <input type="date" name="date" id="date" class="form-control">
                            </div>

                            <!-- الإجراء -->
                            <div class="mb-3">
                                <label for="action" class="form-label">الإجراء</label>
                                <input type="text" name="action" id="action" class="form-control">
                            </div>

                            <!-- رفع الملفات -->
                            <div class="mb-3">
                                <label for="file_path" class="form-label">المستندات</label>
                                <input type="file" name="file_path[]" id="file_path" class="form-control" multiple>
                            </div>

                            <!-- ملاحظة -->
                            <div class="mb-3">
                                <label for="note" class="form-label">ملاحظة</label>
                                <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                            </div>

                            <!-- المحامي -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label">المحامي</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">اختر المحامي</option>
                                    @foreach ($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- زر الحفظ -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

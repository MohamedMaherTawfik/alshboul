@extends('layouts.admin')

@section('title', 'إضافة سجل إجرائي جديد')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="#">السجلات الإجرائية</a>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>إضافة إجراء جديد</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="type" value="إجراء" readonly>

                            <div class="row">
                                <!-- تاريخ الإجراء -->
                                <div class="col-md-6 mb-3">
                                    <label for="date" class="form-label required-field">تاريخ الإجراء</label>
                                    <input type="date" class="form-control" id="date" name="date">
                                </div>

                                <!-- تاريخ الإدخال -->
                                <div class="col-md-6 mb-3">
                                    <label for="created_at" class="form-label required-field">تاريخ الإدخال</label>
                                    <input type="date" class="form-control" id="created_at" name="created_at"
                                        value="{{ now()->format('Y-m-d') }}">
                                </div>


                                <!-- اجراء قادم -->
                                <div class="col-md-6 mb-3">
                                    <label for="next_action" class="form-label">الإجراء القادم</label>
                                    <input type="text" class="form-control" id="next_action" name="next_action">
                                </div>

                                <!-- تاريخ الإجراء القادم -->
                                <div class="col-md-6 mb-3">
                                    <label for="next_action_date" class="form-label">تاريخ الإجراء القادم</label>
                                    <input type="date" class="form-control" id="next_action_date"
                                        name="next_action_date">
                                </div>
                            </div>

                            <!-- المحامي -->
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label required-field">المحامي</label>
                                <select name="user_id" id="user_id" class="form-select">
                                    <option value="" selected disabled>-- اختر المحامي --</option>
                                    @foreach ($lawyers as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- تفاصيل الإجراء -->
                            <div class="mb-3">
                                <label for="action" class="form-label required-field">تفاصيل الإجراء</label>
                                <textarea class="form-control" id="action" name="action" rows="4" placeholder="أدخل تفاصيل الإجراء..."
                                    required></textarea>
                            </div>

                            <!-- ملاحظات -->
                            <div class="mb-3">
                                <label for="note" class="form-label">ملاحظات</label>
                                <textarea class="form-control" id="note" name="note" rows="3" placeholder="أدخل أي ملاحظات إضافية..."></textarea>
                            </div>

                            <!-- رفع الملفات -->
                            <div class="mb-3">
                                <label for="files" class="form-label">رفع مستندات</label>
                                <input type="file" name="files[]" id="files" class="form-control" multiple>
                                <small class="text-muted">يمكنك اختيار أكثر من ملف</small>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4">حفظ</button>
                                <button type="reset" class="btn btn-secondary px-4">إلغاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

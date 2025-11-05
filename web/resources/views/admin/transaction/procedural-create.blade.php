@extends('layouts.admin')

@section('title', 'المعاملات')
@section('main_title_content', 'قائمة المعاملات')
@section('title_content', 'إضافة إجراء')
@section('link_content')
    <a href="{{ route('transactions.all', $transaction->transactionsMain) }}">المعاملات</a>
@endsection

@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white fw-bold text-center">
            إضافة إجراء جديد
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('transactions.procedural.store', $transaction->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- النوع -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">النوع</label>
                        <input type="text" name="type" class="form-control" readonly value="اجراء">
                    </div>

                    <!-- تاريخ الإجراء -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ الإجراء</label>
                        <input type="datetime-local" class="form-control" id="created_at" name="created_at"
                            value="{{ old('created_at', now()->format('Y-m-d\TH:i')) }}">

                    </div>

                    <!-- تفاصيل الإجراء -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الإجراء</label>
                        <textarea name="action" class="form-control" rows="2" required></textarea>
                    </div>

                    <!-- ملاحظات -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الملاحظات</label>
                        <textarea name="note" class="form-control" rows="2"></textarea>
                    </div>

                    <!-- المحامي المسئول -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">المحامي المسئول</label>
                        <select name="user_lawyer_id" class="form-control" required>
                            <option value="">-- اختر المحامي --</option>
                            @foreach (\App\Models\User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->get() as $lawyer)
                                <option value="{{ $lawyer->id }}">{{ $lawyer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- رفع الملفات -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الملفات</label>
                        <input type="file" name="files[]" class="form-control" multiple>
                        <small class="text-muted">يمكنك اختيار أكثر من ملف</small>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('transactions.all', $transaction) }}" class="btn btn-secondary">إلغاء</a>
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </form>
        </div>
    </div>
@endsection

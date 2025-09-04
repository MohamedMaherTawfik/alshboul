@extends('layouts.admin')
@section('title', 'المصاريف')
@section('main_title_content', 'قائمة المصاريف')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('cases.all') }}"> جميع القضايا</a>
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
                <h2 class="page-title">إضافة جلسة قضائية جديدة</h2>
                <p class="text-muted">أدخل تفاصيل الجلسة القضائية للقضية المحددة</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-3">
                <h5 class="card-title mb-0"><i class="bi bi-calendar-event me-2"></i>تفاصيل الجلسة</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('cases.storeAdd', $case) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="جلسه">
                    <!-- معلومات القضية (عرض فقط) -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body py-3">
                                    <h6 class="card-title"><i class="bi bi-folder me-2"></i>معلومات القضية</h6>
                                    <p class="mb-0">رقم القضية: {{ $case->case_number ?? 'غير محدد' }}</p>
                                    <p class="mb-0">اسم الموكل: {{ $case->client->name ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- التاريخ -->
                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label required-field">تاريخ الجلسة</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                    </div>

                    <!-- المحامي -->
                    <div class="col-md-6 mb-3">
                        <label for="lawyer_id" class="form-label required-field">المحامي</label>
                        <select class="form-select" id="lawyer_id" name="lawyer_id" required>
                            <option value="" selected disabled>اختر المحامي</option>
                            @foreach ($lawers as $lawyer)
                                <option value="{{ $lawyer->id }}">{{ $lawyer->name ?? 'غير محدد' }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="row">
                        <!-- رفع الملفات -->
                        <div class="mb-3">
                            <label for="file_path" class="form-label">المستندات</label>
                            <input type="file" name="file_path[]" id="file_path" class="form-control" multiple>
                        </div>
                    </div>

                    <!-- الوقائع -->
                    <div class="mb-3">
                        <label for="facts" class="form-label required-field">وقائع الجلسة</label>
                        <textarea class="form-control" id="facts" name="facts" rows="4" required
                            placeholder="أدخل تفاصيل وقائع الجلسة..."></textarea>
                    </div>

                    <!-- ملاحظات -->
                    <div class="mb-4">
                        <label for="note" class="form-label">ملاحظات</label>
                        <textarea class="form-control" id="note" name="note" rows="3" placeholder="أدخل أي ملاحظات إضافية..."></textarea>
                    </div>

                    <!-- أزرار -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-secondary">مسح الحقول</button>
                        <button type="submit" class="btn btn-primary">حفظ الجلسة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap & Validation Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // دالة للتحقق من صحة النموذج قبل الإرسال
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(event) {
                let isValid = true;

                // التحقق من الحقول المطلوبة
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    alert('يرجى ملء جميع الحقول المطلوبة');
                }
            });

            // إزالة حالة الخطأ عند البدء بالكتابة
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>
@endsection

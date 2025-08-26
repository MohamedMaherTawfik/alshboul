@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('cases.all') }}">جميع القضايا</a>
@endsection

<style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --accent-color: #f8f9fa;
        --border-color: #dee2e6;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
    }

    .header-title {
        color: var(--secondary-color);
        border-right: 4px solid var(--primary-color);
        padding-right: 15px;
        font-weight: 700;
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: var(--secondary-color);
    }

    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
    }

    .card-header {
        background: linear-gradient(to right, #f8f9fa, #e9ecef);
        border-bottom: 1px solid var(--border-color);
        padding: 1.2rem 1.5rem;
        font-weight: 600;
        color: var(--secondary-color);
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1.2rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--secondary-color);
    }

    .form-control,
    .form-select {
        border-radius: 6px;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }

    .readonly-field {
        background-color: #f8f9fa;
        color: #6c757d;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-2px);
    }

    .btn-outline-secondary {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px);
    }

    .input-group-text {
        background-color: #e9ecef;
        border: 1px solid var(--border-color);
    }

    .form-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.03);
    }

    .date-input-group {
        position: relative;
    }

    .date-input-group .form-control {
        padding-right: 40px;
    }

    .date-input-group::after {
        content: "\f133";
        font-family: bootstrap-icons;
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .form-section {
            padding: 1rem;
        }
    }
</style>

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <h2 class="header-title">إضافة مدة قانونية</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cases.all') }}">جميع القضايا</a></li>
                        <li class="breadcrumb-item active" aria-current="page">إضافة مدة قانونية</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-calendar-range me-2"></i>نموذج إضافة مدة قانونية جديدة</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('cases.duration.store', $case) }}" method="POST">
                    @csrf

                    <!-- معلومات القضية (غير قابلة للتعديل) -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="bi bi-folder me-2"></i>معلومات القضية</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="case_number" class="form-label">رقم القضية</label>
                                <input type="text" class="form-control readonly-field" id="case_number"
                                    name="case_number" value="{{ $case->file_number }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="case_type" class="form-label">نوع القضية</label>
                                <input type="text" class="form-control readonly-field" id="case_type" name="case_type"
                                    value="{{ $case->suggestedCases->name ?? '--' }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="client_name" class="form-label">الموكل</label>
                                <input type="text" class="form-control readonly-field" id="client_name"
                                    name="client_name" value="{{ $case->client->name ?? '--' }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="opponent_name" class="form-label">الخصم</label>
                                <input type="text" class="form-control readonly-field" id="opponent_name"
                                    name="opponent_name" value="{{ $case->opponent_name ?? '--' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- بيانات المدة القانونية -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="bi bi-clock-history me-2"></i>بيانات المدة القانونية</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="period_start" class="form-label">تاريخ بداية المدة</label>
                                <div>
                                    <input type="date" class="form-control datepicker" id="period_start"
                                        name="period_start" placeholder="اختر تاريخ البداية" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="period_end" class="form-label">تاريخ نهاية المدة</label>
                                <div>
                                    <input type="date" class="form-control datepicker" id="period_end" name="period_end"
                                        placeholder="اختر تاريخ النهاية" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="period_facts" class="form-label">وقائع المدة</label>
                                <textarea class="form-control" id="period_facts" name="period_facts" rows="4"
                                    placeholder="أدخل وقائع المدة القانونية" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات إضافية -->
                    <div class="form-section">
                        <h5 class="section-title"><i class="bi bi-chat-left-text me-2"></i>معلومات إضافية</h5>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="notes" class="form-label">ملاحظات</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="أدخل أي ملاحظات إضافية"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار الحفظ -->
                    <div class="row mt-4">
                        <div class="col-12 text-start">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check2-circle me-2"></i>حفظ المدة القانونية
                            </button>
                            <button type="reset" class="btn btn-outline-secondary px-4 me-2">
                                <i class="bi bi-x-circle me-2"></i>إلغاء
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

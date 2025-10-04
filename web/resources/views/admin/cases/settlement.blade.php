@extends('layouts.admin')
@section('title', 'إضافة تسوية')
@section('main_title_content', 'إضافة تسوية')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('cases.all') }}">جميع القضايا</a>
@endsection

@section('content')
    <style>
        body {
            background-color: #f4f6f9;
            direction: rtl;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .05);
        }

        .card-header {
            background: linear-gradient(to left, #3498db, #2980b9);
            color: #fff;
            border-radius: 12px 12px 0 0;
            padding: 1rem 1.25rem;
            font-weight: bold;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
            border-bottom: 2px solid #3498db;
            padding-bottom: .3rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: .65rem .9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, .2);
        }

        .readonly-field {
            background: #f1f3f5;
            color: #6c757d;
            font-weight: 500;
        }

        .btn-primary {
            background: #3498db;
            border: none;
            border-radius: 8px;
            padding: .65rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-outline-secondary {
            border-radius: 8px;
            padding: .65rem 1.5rem;
            font-weight: 600;
        }
    </style>

    <div class="container py-4">
        <!-- العنوان والمسار -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold text-dark">إضافة تسوية</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cases.all') }}">جميع القضايا</a></li>
                        <li class="breadcrumb-item active">إضافة تسوية</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- الفورم -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark-text me-2"></i> نموذج إضافة تسوية جديدة
            </div>
            <div class="card-body">
                <form action="{{ route('cases.storeSettlement', $case) }}" method="POST">
                    @csrf

                    <!-- معلومات القضية -->
                    <div class="mb-4">
                        <h5 class="section-title"><i class="bi bi-folder me-2"></i>معلومات القضية</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">نوع الدعوى</label>
                                <input type="text" class="form-control readonly-field"
                                    value="{{ $case->suggestedCases->name }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">رقم الدعوى</label>
                                <input type="text" class="form-control readonly-field" value="{{ $case->file_number }}"
                                    readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">اسم المشترك</label>
                                <input type="text" class="form-control readonly-field"
                                    value="{{ $case->subscriber->name }}" readonly>
                                <input type="hidden" name="client_name" value="{{ $case->subscriber->name }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            </div>
                        </div>
                    </div>

                    <!-- بيانات التسوية -->
                    <div class="mb-4">
                        <h5 class="section-title"><i class="bi bi-card-checklist me-2"></i>بيانات التسوية</h5>
                        <div class="row">
                            <!-- بيانات الخصم -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">صفه الخصم</label>
                                <input type="text" class="form-control readonly-field" name="opponent_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الرقم الوطني للخصم</label>
                                <input type="text" class="form-control readonly-field" name="opponent_national_id"
                                    value="{{ $case->caseOpponents->first()->case_opponent_national_number }}" readonly>
                            </div>

                            <!-- بيانات الموكل -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">صفه الموكل</label>
                                <input type="text" class="form-control readonly-field" name="client_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الرقم الوطني للموكل</label>
                                <input type="text" class="form-control readonly-field" name="client_national_id"
                                    value="{{ $case->client->national_id }}" readonly>
                            </div>

                            <!-- الالتزام -->
                            <div class="col-md-12 mb-3 mt-2">
                                <label class="form-label mt-2">الالتزام</label>
                                <select class="form-select mt-2" name="obligation" required>
                                    <option value="">-- اختر الالتزام --</option>
                                    <option value="ملتزم">ملتزم</option>
                                    <option value="غير ملتزم">غير ملتزم</option>
                                </select>
                            </div>

                            <!-- وقائع التسوية -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">وقائع التسوية</label>
                                <textarea class="form-control" name="partner_name" rows="4" placeholder="أدخل وقائع التسوية..."></textarea>
                            </div>
                        </div>
                    </div>



                    <!-- المعلومات المالية -->
                    <div class="mb-4">
                        <h5 class="section-title"><i class="bi bi-currency-exchange me-2"></i>المعلومات المالية</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">المبلغ</label>
                                <input type="number" step="0.01" class="form-control" name="amount"
                                    placeholder="أدخل المبلغ">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">قيمة الدفعات</label>
                                <input type="number" step="0.01" class="form-control" name="payment_value"
                                    placeholder="أدخل قيمة الدفعات">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">شروط السداد</label>
                                    <select class="form-select" name="payment_terms" id="payment_terms" required>
                                        <option value="">-- اختر شرط السداد --</option>
                                        <option value="شهري">شهري</option>
                                        <option value="أسبوعي">أسبوعي</option>
                                    </select>
                                </div>

                                <!-- خانة شهرية -->
                                <div class="col-md-6 mb-3 d-none" id="monthly_input">
                                    <label class="form-label">اليوم</label>
                                    <input type="number" class="form-control" name="day" min="1"
                                        placeholder="أدخل اليوم">
                                </div>

                                <!-- خانات أسبوعية -->
                                <div class="col-md-6 mb-3 d-none" id="weekly_inputs">
                                    <label class="form-label">الايام</label>
                                    <div class="d-flex gap-2">
                                        <input type="number" class="form-control ml-1" name="week_1" min="1"
                                            placeholder="الاسبوع الاول">
                                        <input type="number" class="form-control ml-1" name="week_2" min="1"
                                            placeholder="الاسبوع الثاني">
                                        <input type="number" class="form-control ml-1" name="week_3" min="1"
                                            placeholder="الاسبوع الثالث">
                                        <input type="number" class="form-control ml-1" name="week_4" min="1"
                                            placeholder="الاسبوع الرابع">
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.getElementById('payment_terms').addEventListener('change', function() {
                                    let monthlyInput = document.getElementById('monthly_input');
                                    let weeklyInputs = document.getElementById('weekly_inputs');

                                    // إخفاء الاثنين في البداية
                                    monthlyInput.classList.add('d-none');
                                    weeklyInputs.classList.add('d-none');

                                    if (this.value === 'شهري') {
                                        monthlyInput.classList.remove('d-none');
                                    } else if (this.value === 'أسبوعي') {
                                        weeklyInputs.classList.remove('d-none');
                                    }
                                });
                            </script>

                        </div>
                    </div>

                    <!-- معلومات إضافية -->
                    <div class="mb-4">
                        <h5 class="section-title"><i class="bi bi-chat-left-text me-2"></i>ملاحظات</h5>
                        <textarea class="form-control" name="notes" rows="4" placeholder="أدخل الملاحظات"></textarea>
                    </div>

                    <!-- الأزرار -->
                    <div class="text-start">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle me-1"></i> حفظ التسوية
                        </button>
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-x-circle me-1"></i> إلغاء
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'القضايا التنفيذية')
@section('title_content', 'إضافة تسوية جديدة')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>إضافة تسوية جديدة</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('executive-case.settlement.store', $executiveCase) }}" method="POST">
                            @csrf

                            <!-- بيانات الدعوى -->
                            <div class="mb-4">
                                <h5 class="fw-bold"><i class="bi bi-file-earmark-text me-2"></i>بيانات الدعوى</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="case_type" class="form-label">نوع الدعوي</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $executiveCase->case_type }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="case_number" class="form-label">رقم الدعوي</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $executiveCase->case_number }}">
                                    </div>
                                </div>
                            </div>

                            <!-- بيانات التسوية -->
                            <div class="mb-4">
                                <h5 class="fw-bold"><i class="bi bi-card-checklist me-2"></i>بيانات التسوية</h5>
                                <div class="row g-3">

                                    <!-- بيانات الخصم -->
                                    <div class="col-md-6">
                                        <label for="opponent_name" class="form-label">صفه الخصم</label>
                                        <input type="text" class="form-control" name="opponent_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="opponent_national_id" class="form-label">الرقم الوطني للخصم</label>
                                        <input type="text" class="form-control" name="opponent_national_id"
                                            value="{{ $executiveCase->opponent_national_id }}" readonly>
                                    </div>

                                    <!-- بيانات الموكل -->
                                    <div class="col-md-6">
                                        <label for="client_name" class="form-label">صفه الموكل</label>
                                        <input type="text" class="form-control" name="client_name">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="client_national_id" class="form-label"> الرقم الوطني للموكل</label>
                                        <input type="text" class="form-control" name="client_national_id"
                                            value="{{ $executiveCase->client_national_id }}" readonly>
                                    </div>

                                    <!-- الالتزام -->
                                    <div class="col-md-6">
                                        <label class="form-label">الالتزام</label>
                                        <select class="form-select" name="obligation" required>
                                            <option value="">-- اختر الالتزام --</option>
                                            <option value="ملتزم">ملتزم</option>
                                            <option value="غير ملتزم">غير ملتزم</option>
                                        </select>
                                    </div>

                                    <!-- وقائع التسوية -->
                                    <div class="col-md-12">
                                        <label class="form-label">وقائع التسوية</label>
                                        <textarea class="form-control" name="partner_name" rows="4" placeholder="أدخل وقائع التسوية..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- المعلومات المالية -->
                            <div class="mb-4">
                                <h5 class="fw-bold"><i class="bi bi-currency-exchange me-2"></i>المعلومات المالية</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="amount" class="form-label">المبلغ</label>
                                        <input type="number" step="0.01" class="form-control" name="amount"
                                            placeholder="أدخل المبلغ">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="payment_value" class="form-label">قيمة الدفعات</label>
                                        <input type="number" step="0.01" class="form-control" name="payment_value"
                                            placeholder="أدخل قيمة الدفعات">
                                    </div>

                                    <!-- شروط السداد -->
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">شروط السداد</label>
                                        <select class="form-select" name="payment_terms" id="payment_terms" required>
                                            <option value="">-- اختر شرط السداد --</option>
                                            <option value="شهري">شهري</option>
                                            <option value="أسبوعي">أسبوعي</option>
                                        </select>
                                    </div>

                                    <!-- خانة شهرية -->
                                    <div class="col-md-6 mt-3 d-none" id="monthly_input">
                                        <label class="form-label">اليوم</label>
                                        <input type="number" class="form-control" name="day" min="1"
                                            placeholder="أدخل اليوم">
                                    </div>

                                    <!-- خانات أسبوعية -->
                                    <div class="col-md-12 mt-3 d-none" id="weekly_inputs">
                                        <label class="form-label">الأيام</label>
                                        <div class="row g-2">
                                            <div class="col-3"><input type="number" class="form-control"
                                                    name="week_1" min="1" placeholder="الأسبوع 1"></div>
                                            <div class="col-3"><input type="number" class="form-control"
                                                    name="week_2" min="1" placeholder="الأسبوع 2"></div>
                                            <div class="col-3"><input type="number" class="form-control"
                                                    name="week_3" min="1" placeholder="الأسبوع 3"></div>
                                            <div class="col-3"><input type="number" class="form-control"
                                                    name="week_4" min="1" placeholder="الأسبوع 4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- معلومات إضافية -->
                            <div class="mb-4">
                                <h5 class="fw-bold"><i class="bi bi-chat-left-text me-2"></i>ملاحظات</h5>
                                <textarea class="form-control" name="notes" rows="4" placeholder="أدخل الملاحظات"></textarea>
                            </div>

                            <!-- زر الحفظ -->
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary btn-lg">حفظ</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script لعرض/إخفاء خانات السداد -->
    <script>
        document.getElementById('payment_terms').addEventListener('change', function() {
            let monthlyInput = document.getElementById('monthly_input');
            let weeklyInputs = document.getElementById('weekly_inputs');

            monthlyInput.classList.add('d-none');
            weeklyInputs.classList.add('d-none');

            if (this.value === 'شهري') {
                monthlyInput.classList.remove('d-none');
            } else if (this.value === 'أسبوعي') {
                weeklyInputs.classList.remove('d-none');
            }
        });
    </script>
@endsection

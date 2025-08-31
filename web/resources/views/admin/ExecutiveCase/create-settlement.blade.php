@extends('layouts.admin')

@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'القضايا التنفيذية')
@section('title_content', 'إضافة تسوية جديدة')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
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
                                        <input type="text" name="case_type" id="case_type" class="form-control" readonly
                                            value="{{ $executiveCase->case_type }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="case_number" class="form-label">رقم الدعوي</label>
                                        <input type="text" name="case_number" id="case_number" class="form-control"
                                            readonly value="{{ $executiveCase->case_number }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="settlement_main_id" class="form-label">نوع التسويه</label>
                                        <select name="settlement_main_id" id="settlement_main_id" class="form-select"
                                            required>
                                            <option value="">-- اختر نوع الدعوي --</option>
                                            @foreach ($settlements as $settlement)
                                                <option value="{{ $settlement->id }}">{{ $settlement->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="obligation" class="form-label">الالتزام</label>
                                        <select class="form-select" id="obligation" name="obligation" required>
                                            <option value="">-- اختر الالتزام --</option>
                                            <option value="ملتزم">ملتزم</option>
                                            <option value="غير ملتزم">غير ملتزم</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- بيانات التسوية -->
                            <div class="mb-4">
                                <h5 class="fw-bold"><i class="bi bi-card-checklist me-2"></i>بيانات التسوية</h5>
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label for="opponent_phone" class="form-label">هاتف الخصم</label>
                                        <input type="text" class="form-control" id="opponent_phone" name="opponent_phone"
                                            placeholder="أدخل هاتف الخصم">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="client_status" class="form-label">صفة الموكل</label>
                                        <input type="text" class="form-control" id="client_status" name="client_status"
                                            placeholder="أدخل صفة الموكل">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="opponent_status" class="form-label">صفة الخصم</label>
                                        <input type="text" class="form-control" id="opponent_status"
                                            name="opponent_status" placeholder="أدخل صفة الخصم">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="opponent_name" class="form-label">اسم الخصم</label>
                                        <input type="text" class="form-control" id="opponent_name" name="opponent_name"
                                            placeholder="أدخل اسم الخصم">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="client_name" class="form-label">اسم الموكل</label>
                                        <input type="text" class="form-control" id="client_name" name="client_name"
                                            placeholder="أدخل اسم الموكل">
                                    </div>
                                </div>
                            </div>

                            <!-- المعلومات المالية -->
                            <div class="mb-4">
                                <h5 class="fw-bold"><i class="bi bi-currency-exchange me-2"></i>المعلومات المالية</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="amount" class="form-label">المبلغ</label>
                                        <input type="number" step="0.01" class="form-control" id="amount"
                                            name="amount" placeholder="أدخل المبلغ">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="payment_value" class="form-label">قيمة الدفعات</label>
                                        <input type="number" step="0.01" class="form-control" id="payment_value"
                                            name="payment_value" placeholder="أدخل قيمة الدفعات">
                                    </div>
                                    <div class="col-md-6 mt-5">
                                        <label for="payment_terms" class="form-label">شروط السداد</label>
                                        <select class="form-select" id="payment_terms" name="payment_terms" required>
                                            <option value="">-- اختر شرط السداد --</option>
                                            <option value="شهري">شهري</option>
                                            <option value="أسبوعي">أسبوعي</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- معلومات إضافية -->
                            <div class="mb-4">
                                <h5 class="fw-bold"><i class="bi bi-chat-left-text me-2"></i>معلومات إضافية</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="notes" class="form-label">ملاحظات</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="أدخل الملاحظات"></textarea>
                                    </div>
                                </div>
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
@endsection

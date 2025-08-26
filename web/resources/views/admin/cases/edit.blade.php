@extends('layouts.admin')
@section('title', 'تعديل القضايا')
@section('main_title_content', 'قائمة تعديل القضايا')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('cases.all') }}">تعديل القضايا</a>
@endsection

@section('content')
    <div class="card shadow-lg p-4 border-0"
        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
        <h3 class="text-xl font-bold mb-4 text-center"
            style="color: #2c3e50; padding: 15px; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-gavel me-2"></i>إضافة قضية جديدة
        </h3>

        <form action="{{ route('cases.update', $case) }}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="row">
                <!-- العميل -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header py-3" style="background-color: #2c3e50; color: white;">
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-user me-2"></i>معلومات العميل</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="client_id" class="form-label fw-bold">العميل</label>
                                <select name="client_id" id="client_id" class="form-select form-select-lg" required
                                    style="border-radius: 10px; padding: 12px;">
                                    <option value={{ $case->client->id }}>{{ $case->client->name }}</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">يرجى اختيار العميل</div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h6 class="border-bottom pb-2"><i class="fas fa-id-card me-2"></i>الأرقام القومية</h6>
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label class="form-label">الرقم الوطني الأول</label>
                                    <input type="text" name="first_national_id" class="form-control"
                                        value="{{ $case->first_national_id }}" placeholder="أدخل الرقم القومي"
                                        style="border-radius: 10px;">
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label class="form-label">الرقم الوطني الثاني</label>
                                    <input type="text" name="second_national_id" class="form-control"
                                        value="{{ $case->second_national_id }}" placeholder="أدخل الرقم القومي"
                                        style="border-radius: 10px;">
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label class="form-label">الرقم الوطني الثالث</label>
                                    <input type="text" name="third_national_id" class="form-control"
                                        value="{{ $case->third_national_id }}" placeholder="أدخل الرقم القومي"
                                        style="border-radius: 10px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- الخصم -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header py-3" style="background-color: #e74c3c; color: white;">
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-user-alt me-2"></i>معلومات الخصم</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">اسم الخصم</label>
                                <input type="text" name="opponent_name" class="form-control" placeholder="أدخل اسم الخصم"
                                    value="{{ $case->opponent_name }}" style="border-radius: 10px;">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">الرقم الوطني للخصم</label>
                                <input type="text" name="opponent_national_id" class="form-control"
                                    value="{{ $case->opponent_national_id }}" placeholder="أدخل الرقم القومي"
                                    style="border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- نوع القضية -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header py-3" style="background-color: #3498db; color: white;">
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-balance-scale me-2"></i>نوع القضية</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label fw-bold">القضية المقترحة</label>
                                    <select name="suggested_case_id" class="form-select"
                                        style="border-radius: 10px; padding: 10px;">
                                        <option value="{{ $case->suggestedCases->id }}">{{ $case->suggestedCases->name }}
                                        </option>
                                        @foreach (App\Models\CaseType::all() as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group mt-4">
                                <label class="form-label fw-bold">نوع القضية</label>
                                <select name="case_type" class="form-select" style="border-radius: 10px; padding: 10px;">
                                    <option value="{{ $case->case_type }}">{{ $case->case_type }}</option>
                                    <option value="حقوقي">حقوقي</option>
                                    <option value="شرعي">شرعي</option>
                                    <option value="جزائي">جزائي</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- معلومات القضية -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header py-3" style="background-color: #27ae60; color: white;">
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-info-circle me-2"></i>معلومات أساسية</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label fw-bold">رقم القضية</label>
                                <input type="text" name="case_number" class="form-control"
                                    value="{{ $case->case_number }}" placeholder="أدخل رقم القضية"
                                    style="border-radius: 10px;">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">اسم المحكمة</label>
                                <input type="text" name="court_name" class="form-control"
                                    value="{{ $case->court_name }}" placeholder="أدخل اسم المحكمة"
                                    style="border-radius: 10px;">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">قيمة القضية</label>
                                <input type="text" name="case_amount" class="form-control"
                                    value="{{ $case->case_amount }}" placeholder="أدخل قيمة القضية"
                                    style="border-radius: 10px;">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">تاريخ الاستحقاق</label>
                                <input type="date" name="benefit_date" class="form-control"
                                    value="{{ $case->benefit_date }}" style="border-radius: 10px;">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">اسم القاضي</label>
                                <input type="text" name="jubge_name" class="form-control"
                                    value="{{ $case->jubge_name }}" placeholder="أدخل اسم القاضي"
                                    style="border-radius: 10px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- معلومات إضافية -->
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header py-3" style="background-color: #9b59b6; color: white;">
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-file-alt me-2"></i>معلومات إضافية</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label fw-bold">تفاصيل القضية</label>
                                <input name="case_details" class="form-control" rows="3"
                                    placeholder="أدخل تفاصيل القضية" value="{{ $case->case_details }}"
                                    style="border-radius: 10px;"></input>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">وصف العميل</label>
                                <input type="text" name="client_description" class="form-control"
                                    value="{{ $case->client_description }}" placeholder="أدخل وصف العميل"
                                    style="border-radius: 10px;">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">معلومات عامة</label>
                                <input name="general_information" class="form-control" rows="2"
                                    placeholder="أدخل معلومات عامة" value="{{ $case->general_information }}"
                                    style="border-radius: 10px;"></input>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">معلومات خاصة</label>
                                <input name="private_information" class="form-control" rows="2"
                                    placeholder="أدخل معلومات خاصة" value="{{ $case->private_information }}"
                                    style="border-radius: 10px;"></input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- زر الإضافة -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-lg"
                    style="background: linear-gradient(135deg, #2c3e50 0%, #1a2530 100%); color: white; padding: 12px 40px; border-radius: 50px; font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    <i class="fas fa-plus-circle me-2"></i>تعديل القضية
                </button>
            </div>
        </form>
    </div>

    <style>
        .form-control,
        .form-select {
            transition: all 0.3s;
            border: 1px solid #ddd;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .card {
            border-radius: 15px;
            border: none;
        }

        .form-label {
            color: #2c3e50;
            margin-bottom: 8px;
        }
    </style>

    <script>
        // دالة للتحقق من صحة النموذج
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
@endsection

@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'تعديل')


@section('content')
    <div class="card shadow-lg p-4 border-0"
        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
        <h3 class="text-xl font-bold mb-4 text-center"
            style="color: #2c3e50; padding: 15px; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-gavel me-2"></i>تعديل القضية
        </h3>

        <form action="{{ route('cases.update', $case->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="row">
                <!-- العميل -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header py-3" style="background-color: #2c3e50; color: white;">
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-user me-2"></i>معلومات الموكل</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="subscriber_id" class="form-label fw-bold">المشترك</label>
                                <select name="subscriber_id" id="subscriber_id" class="form-select form-select-lg" required>
                                    <option value="">-- اختر المشترك --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" data-name="{{ $user->name }}"
                                            data-clients='@json($user->client)'
                                            {{ $case->subscriber_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="client_id" class="form-label fw-bold">الموكل</label>
                                <select name="client_id" id="client_id" class="form-select form-select-lg" required>
                                    <option value="">-- اختر الموكل --</option>
                                    @if ($case->client)
                                        <option value="{{ $case->client->id }}" selected>{{ $case->client->name }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h6 class="border-bottom pb-2"><i class="fas fa-id-card me-2"></i>الأرقام القومية</h6>
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label class="form-label">الرقم الوطني الأول</label>
                                    <input type="text" name="first_national_id" class="form-control"
                                        value="{{ $case->first_national_id }}" style="border-radius: 10px;">
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label class="form-label">الرقم الوطني الثاني</label>
                                    <input type="text" name="second_national_id" class="form-control"
                                        value="{{ $case->second_national_id }}" style="border-radius: 10px;">
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label class="form-label">الرقم الوطني الثالث</label>
                                    <input type="text" name="third_national_id" class="form-control"
                                        value="{{ $case->third_national_id }}" style="border-radius: 10px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- الخصوم -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center"
                            style="background-color: #e74c3c; color: white;">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-user-alt me-2"></i>معلومات الخصوم
                            </h6>
                            <button type="button" class="btn btn-light btn-sm" id="add-opponent">+ إضافة خصم</button>
                        </div>
                        <div class="card-body" id="opponents-wrapper">
                            @foreach ($case->caseOpponents as $opponent)
                                <div class="opponent-item mb-3 p-3 border rounded">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">اسم الخصم</label>
                                        <input type="text" name="opponent_name[]" class="form-control"
                                            value="{{ $opponent->case_opponent_name }}" style="border-radius: 10px;"
                                            required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label fw-bold">الرقم الوطني للخصم</label>
                                        <input type="text" name="opponent_national_id[]" class="form-control"
                                            value="{{ $opponent->case_opponent_national_number }}"
                                            style="border-radius: 10px;" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label fw-bold">وصف الخصم</label>
                                        <textarea name="opponent_description[]" class="form-control" style="border-radius: 10px;">{{ $opponent->case_opponent_description }}</textarea>
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm mt-3 remove-opponent">حذف
                                        الخصم</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- باقي الحقول (نفس الكود بتاعك) -->
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
                                    <select name="suggested_case_id" class="form-select" id="">
                                        @foreach ($caseTypes as $item)
                                            <option value="{{ $item->id }}" @selected($case->suggested_case_id == $item->id)>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <label class="form-label fw-bold">نوع القضية</label>
                                <input type="text" name="case_type" class="form-control"
                                    value="{{ $case->case_type }}" style="border-radius: 10px;" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- مثال باقي المعلومات -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header py-3" style="background-color: #27ae60; color: white;">
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-info-circle me-2"></i>معلومات أساسية</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label fw-bold">رقم الدعوي</label>
                                <input type="text" name="file_number" class="form-control"
                                    value="{{ $case->file_number }}" style="border-radius: 10px;" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">اسم المحكمة</label>
                                <input type="text" name="court_name" class="form-control"
                                    value="{{ $case->court_name }}" style="border-radius: 10px;" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">قيمة القضية</label>
                                <input type="text" name="case_amount" class="form-control"
                                    value="{{ $case->case_amount }}" style="border-radius: 10px;" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">تاريخ الاستحقاق</label>
                                <input type="date" name="benefit_date" class="form-control"
                                    value="{{ $case->benefit_date }}" style="border-radius: 10px;" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">اسم القاضي</label>
                                <input type="text" name="jubge_name" class="form-control"
                                    value="{{ $case->jubge_name }}" style="border-radius: 10px;" required>
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
                                <textarea name="case_details" class="form-control" rows="3" style="border-radius: 10px;">{{ $case->case_details }}</textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">وصف العميل</label>
                                <input type="text" name="client_description" class="form-control"
                                    value="{{ $case->client_description }}" style="border-radius: 10px;">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">معلومات عامة</label>
                                <textarea name="general_information" class="form-control" rows="2" style="border-radius: 10px;">{{ $case->general_information }}</textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">معلومات خاصة</label>
                                <textarea name="private_information" class="form-control" rows="2" style="border-radius: 10px;">{{ $case->private_information }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- زر التعديل -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-lg"
                    style="background: linear-gradient(135deg, #2c3e50 0%, #1a2530 100%); color: white; padding: 12px 40px; border-radius: 50px; font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    <i class="fas fa-save me-2"></i>تعديل القضية
                </button>
            </div>
        </form>
    </div>
@endsection

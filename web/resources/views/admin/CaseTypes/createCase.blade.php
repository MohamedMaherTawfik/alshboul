@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'عرض')
@section('link_content')
    <a href="{{ route('casetypes.index') }}">أنواع القضايا</a>
@endsection

@section('content')
    <div class="card shadow-lg p-4 border-0"
        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
        <h3 class="text-xl font-bold mb-4 text-center"
            style="color: #2c3e50; padding: 15px; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <i class="fas fa-gavel me-2"></i>إضافة قضية جديدة
        </h3>

        <form action="{{ route('casetypes.store.case', $case) }}" method="POST" class="needs-validation" novalidate>
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
                                            data-clients='@json($user->client)'>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="client_id" class="form-label fw-bold">الموكل</label>
                                <select name="client_id" id="client_id" class="form-select form-select-lg" required
                                    disabled>
                                    <option value="">-- اختر الموكل --</option>
                                </select>
                            </div>


                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h6 class="border-bottom pb-2"><i class="fas fa-id-card me-2"></i>الأرقام القومية</h6>
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label class="form-label">الرقم الوطني الأول</label>
                                    <input type="text" name="first_national_id" class="form-control"
                                        placeholder="أدخل الرقم القومي" style="border-radius: 10px;">
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label class="form-label">الرقم الوطني الثاني</label>
                                    <input type="text" name="second_national_id" class="form-control"
                                        placeholder="أدخل الرقم القومي" style="border-radius: 10px;">
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <label class="form-label">الرقم الوطني الثالث</label>
                                    <input type="text" name="third_national_id" class="form-control"
                                        placeholder="أدخل الرقم القومي" style="border-radius: 10px;">
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
                            <div class="opponent-item mb-3 p-3 border rounded">
                                <!-- اسم الخصم -->
                                <div class="form-group">
                                    <label class="form-label fw-bold">اسم الخصم</label>
                                    <input type="text" name="opponent_name[]" class="form-control"
                                        placeholder="أدخل اسم الخصم" style="border-radius: 10px;" required>
                                </div>

                                <!-- الرقم الوطني -->
                                <div class="form-group mt-3">
                                    <label class="form-label fw-bold">الرقم الوطني للخصم</label>
                                    <input type="text" name="opponent_national_id[]" class="form-control"
                                        placeholder="أدخل الرقم القومي" style="border-radius: 10px;" required>
                                </div>

                                <!-- وصف الخصم -->
                                <div class="form-group mt-3">
                                    <label class="form-label fw-bold">وصف الخصم</label>
                                    <textarea name="opponent_description[]" class="form-control" placeholder="أدخل وصف الخصم (اختياري)"
                                        style="border-radius: 10px;"></textarea>
                                </div>

                                <button type="button" class="btn btn-danger btn-sm mt-3 remove-opponent">حذف الخصم</button>
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
                                    <input type="text" value="{{ $case->name }}" class="form-control"
                                        style="border-radius: 10px;" readonly>
                                    <input type="hidden" name="suggested_case_id" value="{{ $case->id }}">
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label class="form-label fw-bold">نوع القضية</label>
                                <input type="text" name="case_type" class="form-control"
                                    style="border-radius: 10px; padding: 10px;" placeholder="اكتب نوع القضية" required>
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
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-info-circle me-2"></i>معلومات أساسية
                            </h6>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <p>رقم الملف المقترح : {{ $missing }} </p>
                                <input type="hidden" name="case_number" value="{{ $missing }}">
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label fw-bold"> رقم الدعوي</label>
                                <input type="text" name="file_number" class="form-control"
                                    style="border-radius: 10px;" required>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">اسم المحكمة</label>
                                <input type="text" name="court_name" class="form-control"
                                    placeholder="أدخل اسم المحكمة" style="border-radius: 10px;" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">قيمة القضية</label>
                                <input type="text" name="case_amount" class="form-control"
                                    placeholder="أدخل قيمة القضية" style="border-radius: 10px;" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">تاريخ الاستحقاق</label>
                                <input type="date" name="benefit_date" class="form-control"
                                    style="border-radius: 10px;" required>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">اسم القاضي</label>
                                <input type="text" name="jubge_name" class="form-control"
                                    placeholder="أدخل اسم القاضي" style="border-radius: 10px;" required>
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
                                <textarea name="case_details" class="form-control" rows="3" placeholder="أدخل تفاصيل القضية"
                                    style="border-radius: 10px;"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">وصف العميل</label>
                                <input type="text" name="client_description" class="form-control"
                                    placeholder="أدخل وصف العميل" style="border-radius: 10px;">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">معلومات عامة</label>
                                <textarea name="general_information" class="form-control" rows="2" placeholder="أدخل معلومات عامة"
                                    style="border-radius: 10px;"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label fw-bold">معلومات خاصة</label>
                                <textarea name="private_information" class="form-control" rows="2" placeholder="أدخل معلومات خاصة"
                                    style="border-radius: 10px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- زر الإضافة -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-lg"
                    style="background: linear-gradient(135deg, #2c3e50 0%, #1a2530 100%); color: white; padding: 12px 40px; border-radius: 50px; font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    <i class="fas fa-plus-circle me-2"></i>إضافة القضية
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

        .opponent-item {
            background-color: #f8f9fa;
            transition: all 0.3s;
        }

        .opponent-item:hover {
            background-color: #e9ecef;
        }
    </style>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const subscriberSelect = document.getElementById("subscriber_id");
            const clientSelect = document.getElementById("client_id");
            const firstNationalIdInput = document.querySelector("input[name='first_national_id']");

            // لما يغير المشترك
            subscriberSelect.addEventListener("change", function() {
                clientSelect.innerHTML = '<option value="">-- اختر الموكل --</option>'; // فاضي الاختيارات
                clientSelect.disabled = true;
                firstNationalIdInput.value = "";
                firstNationalIdInput.removeAttribute("readonly");

                const selectedOption = this.options[this.selectedIndex];
                const clients = selectedOption.getAttribute("data-clients");

                if (clients) {
                    let parsedClients = JSON.parse(clients);

                    if (parsedClients.length > 0) {
                        parsedClients.forEach(client => {
                            let option = document.createElement("option");
                            option.value = client.id;
                            option.textContent = client.name;
                            option.setAttribute("data-national-id", client.national_id);
                            clientSelect.appendChild(option);
                        });

                        clientSelect.disabled = false;
                    }
                }
            });

            // لما يغير الموكل
            clientSelect.addEventListener("change", function() {
                const selectedOption = this.options[this.selectedIndex];
                const nationalId = selectedOption.getAttribute("data-national-id");

                if (nationalId) {
                    firstNationalIdInput.value = nationalId;
                    firstNationalIdInput.setAttribute("readonly", true);
                } else {
                    firstNationalIdInput.value = "";
                    firstNationalIdInput.removeAttribute("readonly");
                }
            });
        });
    </script>

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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.getElementById('opponents-wrapper');
            const addBtn = document.getElementById('add-opponent');

            // إضافة خصم جديد
            addBtn.addEventListener('click', function() {
                let firstOpponent = wrapper.querySelector('.opponent-item');
                let clone = firstOpponent.cloneNode(true);

                // مسح القيم
                clone.querySelectorAll('input, textarea').forEach(input => input.value = '');

                wrapper.appendChild(clone);

                // إعادة تفعيل زرار الحذف
                activateRemoveButtons();
            });

            function activateRemoveButtons() {
                document.querySelectorAll('.remove-opponent').forEach(btn => {
                    btn.onclick = function() {
                        if (document.querySelectorAll('.opponent-item').length > 1) {
                            this.closest('.opponent-item').remove();
                        } else {
                            alert('يجب أن يبقى خصم واحد على الأقل.');
                        }
                    }
                });
            }

            activateRemoveButtons();
        });
    </script>
@endsection

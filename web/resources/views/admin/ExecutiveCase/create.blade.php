@extends('layouts.admin')

@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('executive-case.index', $item) }}">قضايا تنفيذية</a>
@endsection

@section('content')
    <div class="container-fluid">
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-plus-circle mr-2"></i>
                    إضافة قضية تنفيذية جديدة
                </h3>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('executive-case.store', $item) }}">
                    @csrf

                    <!-- معلومات المشترك -->
                    <div class="section-wrapper mb-4">
                        <h5 class="section-title mb-3 pb-2 border-bottom">
                            <i class="fas fa-user mr-2"></i>معلومات المشترك
                        </h5>

                        <div class="row">
                            <!-- رقم المشترك -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subscriber_number" class="form-label">رقم المشترك</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" id="subscriber_number" name="subscriber_number"
                                            class="form-control @error('subscriber_number') is-invalid @enderror"
                                            value="{{ old('subscriber_number') }}" readonly>
                                    </div>
                                    @error('subscriber_number')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- المشترك -->
                            <div class="col-md-6">
                                <div class="form-group position-relative">
                                    <label for="subscriber_name" class="form-label">المشترك</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" id="subscriber_name" class="form-control"
                                            placeholder="ابحث عن المشترك..." autocomplete="off">
                                    </div>
                                    <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">
                                    <div id="subscriber_suggestions" class="list-group position-absolute w-100"
                                        style="z-index: 1000; max-height: 200px; overflow-y: auto; display:none;"></div>
                                    @error('user_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات الموكل -->
                    <div class="section-wrapper mb-4">
                        <h5 class="section-title mb-3 pb-2 border-bottom">
                            <i class="fas fa-user-tie mr-2"></i>معلومات الموكل
                        </h5>

                        <div class="row">
                            <!-- الموكل -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_name" class="form-label">الموكل</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                        </div>
                                        <select id="client_name" name="client_name"
                                            class="form-control @error('client_name') is-invalid @enderror">
                                            <option value="" selected>اختر الموكل</option>
                                        </select>
                                    </div>
                                    @error('client_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- الرقم الوطني للموكل -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_national_id" class="form-label">الرقم الوطني للموكل</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light"><i class="fas fa-id-card"></i></span>
                                        </div>
                                        <input type="text" id="client_national_id" name="client_national_id"
                                            class="form-control @error('client_national_id') is-invalid @enderror"
                                            value="{{ old('client_national_id') }}" readonly>
                                    </div>
                                    @error('client_national_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- قسم الخصوم -->
                    <div class="section-wrapper mb-4">
                        <h5 class="section-title mb-3 pb-2 border-bottom">
                            <i class="fas fa-users mr-2"></i>الخصوم
                        </h5>

                        <div class="row">
                            <div class="col-12">
                                <div id="opponents-wrapper">
                                    <div class="opponent-row card card-body bg-light mb-3">
                                        <div class="row align-items-end">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="form-label">اسم الخصم</label>
                                                    <input type="text" name="opponents[0][name]" class="form-control"
                                                        placeholder="اسم الخصم">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label class="form-label">الرقم الوطني للخصم</label>
                                                    <input type="text" name="opponents[0][national_id]"
                                                        class="form-control" placeholder="الرقم الوطني">
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <button type="button" class="btn btn-danger remove-opponent btn-block">
                                                    <i class="fas fa-trash mr-1"></i> حذف
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="add-opponent" class="btn btn-outline-success">
                                    <i class="fas fa-plus mr-1"></i> إضافة خصم
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات القضية -->
                    <div class="section-wrapper mb-4">
                        <h5 class="section-title mb-3 pb-2 border-bottom">
                            <i class="fas fa-gavel mr-2"></i>معلومات القضية
                        </h5>

                        <div class="row">
                            <!-- الصف الأول -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="case_number" class="form-label">رقم الدعوى</label>
                                    <input type="text" name="case_number" class="form-control"
                                        value="{{ old('case_number') }}" placeholder="رقم الدعوى">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="execution_court" class="form-label">دائره الدعوى</label>
                                    <input type="text" name="execution_court" class="form-control"
                                        value="{{ old('execution_court') }}" placeholder="دائره الدعوى">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="judged_for" class="form-label"> صفه المحكوم له</label>
                                    <input type="text" name="judged_for" class="form-control"
                                        value="{{ old('judged_for') }}" placeholder="المحكوم له">
                                </div>
                            </div>

                            <!-- الصف الثاني -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="judged_against" class="form-label"> صفه المحكوم عليه</label>
                                    <input type="text" name="judged_against" class="form-control"
                                        value="{{ old('judged_against') }}" placeholder="المحكوم عليه">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="execution_document_number" class="form-label">رقم السند التنفيذي</label>
                                    <input type="text" name="execution_document_number" class="form-control"
                                        value="{{ old('execution_document_number') }}" placeholder="رقم السند">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="execution_document_type" class="form-label">نوع السند التنفيذي</label>
                                    <input type="text" name="execution_document_type" class="form-control"
                                        value="{{ old('execution_document_type') }}" placeholder="نوع السند">
                                </div>
                            </div>

                            <!-- الصف الثالث -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="file_number" class="form-label">رقم الملف</label>
                                    <input type="text" name="file_number" class="form-control"
                                        value="{{ $missing }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="case_type" class="form-label">نوع القضية التنفيذية</label>
                                    <input type="text" name="case_type" class="form-control"
                                        value="{{ old('case_type') }}" placeholder="نوع القضية">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="case_status" class="form-label">حالة القضية</label>
                                    <input type="text" name="case_status" class="form-control"
                                        value="{{ old('case_status') }}" placeholder="حالة القضية">
                                </div>
                            </div>

                            <!-- الصف الرابع -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="procedural_session_date" class="form-label">تاريخ الجلسه الاجرائيه</label>
                                    <input type="text" name="procedural_session_date" class="form-control"
                                        value="{{ old('procedural_session_date') }}"
                                        placeholder="تاريخ الجلسه الاجرائيه">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="case_value" class="form-label">قيمة الدعوى</label>
                                    <input type="text" step="0.01" name="case_value" class="form-control"
                                        value="{{ old('case_value') }}" placeholder="قيمة الدعوى">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- زر الحفظ -->
                    <div class="mt-4 text-center form-group">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-save mr-2"></i> حفظ القضية
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const subscriberInput = document.getElementById("subscriber_name");
            const subscriberHidden = document.getElementById("user_id");
            const subscriberNumber = document.getElementById("subscriber_number");
            const suggestionsBox = document.getElementById("subscriber_suggestions");
            const clientSelect = document.getElementById("client_name");
            const clientNationalId = document.getElementById("client_national_id");

            // 🟩 استدعاء المستخدمين من السيرفر (جاية من الكنترولر)
            const users = @json($users);

            // 🔍 البحث التلقائي عن المشتركين
            subscriberInput.addEventListener("input", function() {
                const query = this.value.toLowerCase();
                suggestionsBox.innerHTML = "";
                subscriberHidden.value = "";
                subscriberNumber.value = "";
                clientSelect.innerHTML = '<option value="">اختر الموكل</option>';
                clientNationalId.value = "";

                if (query.length < 1) {
                    suggestionsBox.style.display = "none";
                    return;
                }

                const filtered = users.filter(user => user.name.toLowerCase().includes(query));
                if (!filtered.length) {
                    suggestionsBox.style.display = "none";
                    return;
                }

                filtered.forEach(user => {
                    const item = document.createElement("button");
                    item.type = "button";
                    item.className = "list-group-item list-group-item-action";
                    item.textContent = user.name;
                    item.onclick = () => {
                        // ✅ عند اختيار مشترك
                        subscriberInput.value = user.name;
                        subscriberHidden.value = user.id;
                        subscriberNumber.value = user.id; // رقم المشترك مثلاً ID
                        suggestionsBox.style.display = "none";

                        // تصفير الحقول القديمة
                        clientSelect.innerHTML = '<option value="">اختر الموكل</option>';
                        clientNationalId.value = "";

                        // تحميل الموكلين المرتبطين بالمشترك
                        if (user.client && user.client.length) {
                            user.client.forEach(client => {
                                const opt = document.createElement("option");
                                opt.value = client.name;
                                opt.textContent = client.name;
                                opt.setAttribute("data-national-id", client
                                    .national_id);
                                clientSelect.appendChild(opt);
                            });
                        }
                    };
                    suggestionsBox.appendChild(item);
                });

                suggestionsBox.style.display = "block";
            });

            // 🟨 عند اختيار الموكل
            clientSelect.addEventListener("change", function() {
                const selectedOption = this.options[this.selectedIndex];
                const nationalId = selectedOption?.getAttribute("data-national-id");

                if (nationalId) {
                    clientNationalId.value = nationalId;
                } else {
                    clientNationalId.value = "";
                }
            });

            // 🔻 إخفاء قائمة الاقتراحات عند الضغط خارجها
            document.addEventListener("click", function(e) {
                if (!subscriberInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.style.display = "none";
                }
            });
        });
    </script>


    <!-- سكريبت الخصوم -->
    <script>
        document.getElementById('add-opponent').addEventListener('click', function() {
            const wrapper = document.getElementById('opponents-wrapper');
            const count = wrapper.querySelectorAll('.opponent-row').length;
            const row = document.createElement('div');
            row.classList.add('opponent-row', 'card', 'card-body', 'bg-light', 'mb-3');

            row.innerHTML = `
            <div class="row align-items-end">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="form-label">اسم الخصم</label>
                        <input type="text" name="opponents[${count}][name]" class="form-control" placeholder="اسم الخصم">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="form-label">الرقم الوطني للخصم</label>
                        <input type="text" name="opponents[${count}][national_id]" class="form-control" placeholder="الرقم الوطني">
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <button type="button" class="btn btn-danger remove-opponent btn-block">
                        <i class="fas fa-trash mr-1"></i> حذف
                    </button>
                </div>
            </div>
        `;
            wrapper.appendChild(row);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-opponent') || e.target.closest('.remove-opponent')) {
                const btn = e.target.classList.contains('remove-opponent') ? e.target : e.target.closest(
                    '.remove-opponent');
                btn.closest('.opponent-row').remove();
            }
        });
    </script>

    <style>
        .section-wrapper {
            padding: 1.5rem;
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
            background-color: #f8f9fc;
        }

        .section-title {
            color: #2c3e50;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .card-header {
            border-radius: 0.375rem 0.375rem 0 0 !important;
        }

        .opponent-row {
            transition: all 0.3s ease;
        }

        .opponent-row:hover {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            border-color: #80bdff;
        }
    </style>
@endsection

@extends('layouts.admin')
@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('executive-case.index', $item) }}">قضايا تنفيذية</a>
@endsection
@section('content')
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ session('message') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">إضافة قضية تنفيذية جديدة</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('executive-case.store', $item) }}">
                    @csrf
                    <div class="row">
                        <!-- رقم المشترك -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subscriber_number">رقم المشترك</label>
                                <input type="text" id="subscriber_number" name="subscriber_number"
                                    class="form-control @error('subscriber_number') is-invalid @enderror"
                                    value="{{ old('subscriber_number') }}" readonly>
                                @error('subscriber_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- المشترك -->
                        <div class="col-md-6">
                            <div class="form-group position-relative">
                                <label for="subscriber_name">المشترك</label>
                                <input type="text" id="subscriber_name" class="form-control"
                                    placeholder="ابحث عن المشترك..." autocomplete="off">
                                <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">
                                <div id="subscriber_suggestions" class="list-group position-absolute w-100"
                                    style="z-index: 1000; max-height: 200px; overflow-y: auto; display:none;"></div>
                                @error('user_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- الموكل -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_name">الموكل</label>
                                <select id="client_name" name="client_name"
                                    class="form-control @error('client_name') is-invalid @enderror">
                                    <option value="" selected>اختر الموكل</option>
                                </select>
                                @error('client_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- الرقم الوطني للموكل -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_national_id">الرقم الوطني للموكل</label>
                                <input type="text" id="client_national_id" name="client_national_id"
                                    class="form-control @error('client_national_id') is-invalid @enderror"
                                    value="{{ old('client_national_id') }}" readonly>
                                @error('client_national_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- باقي الحقول زي ما هي -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="opponent_name">اسم الخصم</label>
                                <input type="text" name="opponent_name"
                                    class="form-control @error('opponent_name') is-invalid @enderror"
                                    value="{{ old('opponent_name') }}">
                                @error('opponent_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="opponent_national_id">الرقم الوطني للخصم</label>
                                <input type="text" name="opponent_national_id"
                                    class="form-control @error('opponent_national_id') is-invalid @enderror"
                                    value="{{ old('opponent_national_id') }}">
                                @error('opponent_national_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- أرقام الملفات -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="case_number">رقم الدعوى</label>
                                <input type="text" name="case_number"
                                    class="form-control @error('case_number') is-invalid @enderror"
                                    value="{{ old('case_number') }}">
                                @error('case_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="file_number">رقم الملف</label>
                                <input type="text" name="file_number"
                                    class="form-control @error('file_number') is-invalid @enderror"
                                    value="{{ $missing }}" readonly>
                                @error('file_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- نوع القضية وحالتها -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="case_type">نوع القضية التنفيذية</label>
                                <input type="text" name="case_type"
                                    class="form-control @error('case_type') is-invalid @enderror"
                                    value="{{ old('case_type') }}">
                                @error('case_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="case_status">حالة القضية</label>
                                <input type="text" name="case_status" class="form-control "
                                    value="{{ old('case_status') }}">
                                @error('case_status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- قيمة الدعوى -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="case_value">قيمة الدعوى</label>
                                <input type="number" step="0.01" name="case_value"
                                    class="form-control @error('case_value') is-invalid @enderror"
                                    value="{{ old('case_value') }}">
                                @error('case_value')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- معلومات التنفيذ -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="execution_court">الدائرة التنفيذية</label>
                                <input type="text" name="execution_court"
                                    class="form-control @error('execution_court') is-invalid @enderror"
                                    value="{{ old('execution_court') }}">
                                @error('execution_court')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="execution_document_type">نوع السند التنفيذي</label>
                                <input type="text" name="execution_document_type"
                                    class="form-control @error('execution_document_type') is-invalid @enderror"
                                    value="{{ old('execution_document_type') }}">
                                @error('execution_document_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="judged_for_status">صفة المحكوم له</label>
                                <input type="text" name="judged_for_status"
                                    class="form-control @error('judged_for_status') is-invalid @enderror"
                                    value="{{ old('judged_for_status') }}">
                                @error('judged_for_status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="judged_against_status">صفة المحكوم عليه</label>
                                <input type="text" name="judged_against_status"
                                    class="form-control @error('judged_against_status') is-invalid @enderror"
                                    value="{{ old('judged_against_status') }}">
                                @error('judged_against_status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- التواريخ -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registration_date">تاريخ التسجيل</label>
                                <input type="date" name="registration_date"
                                    class="form-control @error('registration_date') is-invalid @enderror"
                                    value="{{ old('registration_date') }}">
                                @error('registration_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="execution_document_number">رقم السند التنفيذي</label>
                                <input type="text" name="execution_document_number"
                                    class="form-control @error('execution_document_number') is-invalid @enderror"
                                    value="{{ old('execution_document_number') }}">
                                @error('execution_document_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="procedural_session_date">تاريخ الجلسة الإجرائية</label>
                                <input type="date" name="procedural_session_date"
                                    class="form-control @error('procedural_session_date') is-invalid @enderror"
                                    value="{{ old('procedural_session_date') }}">
                                @error('procedural_session_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center form-group">
                        <button type="submit" class="btn btn-primary">حفظ القضية</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- اسكريبت البحث الحي -->
    <script>
        const users = @json($clients->groupBy('user_id')->map->first());
        const allClients = @json($clients);

        const subscriberInput = document.getElementById("subscriber_name");
        const subscriberHidden = document.getElementById("user_id");
        const subscriberNumber = document.getElementById("subscriber_number");
        const suggestionsBox = document.getElementById("subscriber_suggestions");
        const clientSelect = document.getElementById("client_name");
        const clientNationalId = document.getElementById("client_national_id");

        subscriberInput.addEventListener("input", function() {
            let query = this.value.toLowerCase();
            suggestionsBox.innerHTML = "";
            subscriberHidden.value = "";
            subscriberNumber.value = "";

            if (query.length < 1) {
                suggestionsBox.style.display = "none";
                return;
            }

            let filtered = Object.values(users).filter(user => user.name.toLowerCase().includes(query));

            if (filtered.length === 0) {
                suggestionsBox.style.display = "none";
                return;
            }

            filtered.forEach(user => {
                let item = document.createElement("button");
                item.type = "button";
                item.className = "list-group-item list-group-item-action";
                item.textContent = user.name;
                item.onclick = function() {
                    subscriberInput.value = user.name;
                    subscriberHidden.value = user.user_id;
                    subscriberNumber.value = user.id;
                    suggestionsBox.style.display = "none";

                    // تحميل الموكلين
                    let filteredClients = allClients.filter(c => c.user_id == user.user_id);
                    clientSelect.innerHTML = '<option value="">اختر الموكل</option>';
                    filteredClients.forEach(c => {
                        let opt = document.createElement("option");
                        opt.value = c.name;
                        opt.textContent = c.name;
                        opt.dataset.nationalId = c.national_id;
                        clientSelect.appendChild(opt);
                    });
                };
                suggestionsBox.appendChild(item);
            });

            suggestionsBox.style.display = "block";
        });

        clientSelect.addEventListener("change", function() {
            let nationalId = this.options[this.selectedIndex].dataset.nationalId || "";
            clientNationalId.value = nationalId;
        });
    </script>
@endsection

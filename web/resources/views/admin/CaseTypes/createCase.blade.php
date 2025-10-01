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
                            <!-- المشترك مع Autocomplete -->
                            <div class="form-group mb-3 position-relative">
                                <label for="subscriber_name" class="form-label fw-bold">المشترك</label>
                                <input type="text" id="subscriber_name" class="form-control form-control-lg"
                                    placeholder="اكتب اسم المشترك" autocomplete="off" required>
                                <input type="hidden" name="subscriber_id" id="subscriber_id">

                                <!-- قائمة الاقتراحات -->
                                <div id="subscriber_suggestions" class="list-group position-absolute w-100"
                                    style="z-index: 1000; max-height: 200px; overflow-y: auto; display: none;">
                                </div>
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
                                <div class="form-group">
                                    <label class="form-label fw-bold">اسم الخصم</label>
                                    <input type="text" name="opponent_name[]" class="form-control"
                                        placeholder="أدخل اسم الخصم" style="border-radius: 10px;" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="form-label fw-bold">الرقم الوطني للخصم</label>
                                    <input type="text" name="opponent_national_id[]" class="form-control"
                                        placeholder="أدخل الرقم القومي" style="border-radius: 10px;" required>
                                </div>
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

            <!-- باقي الفورم زي ما هو -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-lg"
                    style="background: linear-gradient(135deg, #2c3e50 0%, #1a2530 100%); color: white; padding: 12px 40px; border-radius: 50px; font-weight: bold; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                    <i class="fas fa-plus-circle me-2"></i>إضافة القضية
                </button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const subscriberInput = document.getElementById("subscriber_name");
            const subscriberHidden = document.getElementById("subscriber_id");
            const suggestionsBox = document.getElementById("subscriber_suggestions");
            const clientSelect = document.getElementById("client_id");
            const firstNationalIdInput = document.querySelector("input[name='first_national_id']");

            // users جايين من السيرفر
            const users = @json($users);

            subscriberInput.addEventListener("input", function() {
                const query = this.value.toLowerCase();
                suggestionsBox.innerHTML = "";
                subscriberHidden.value = "";

                if (query.length < 1) {
                    suggestionsBox.style.display = "none";
                    return;
                }

                let filtered = users.filter(user => user.name.toLowerCase().includes(query));

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
                        subscriberHidden.value = user.id;
                        suggestionsBox.style.display = "none";

                        // تفريغ العملاء
                        clientSelect.innerHTML = '<option value="">-- اختر الموكل --</option>';
                        clientSelect.disabled = true;
                        firstNationalIdInput.value = "";
                        firstNationalIdInput.removeAttribute("readonly");

                        if (user.client && user.client.length > 0) {
                            user.client.forEach(client => {
                                let opt = document.createElement("option");
                                opt.value = client.id;
                                opt.textContent = client.name;
                                opt.setAttribute("data-national-id", client
                                .national_id);
                                clientSelect.appendChild(opt);
                            });
                            clientSelect.disabled = false;
                        }
                    };
                    suggestionsBox.appendChild(item);
                });

                suggestionsBox.style.display = "block";
            });

            // لما يختار الموكل يظهر الرقم القومي
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
@endsection

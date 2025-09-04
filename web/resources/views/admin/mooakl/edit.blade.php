@extends('layouts.admin')
@section('title', 'تعديل الموكل ')
@section('main_title_content', 'تعديل بيانات الموكل')
@section('link_content')
    <a href="{{ route('client.index') }}">موكلين</a>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> تعديل بيانات الموكل </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('client.update', $client->id) }}" method="post" id="clientForm">
                    @csrf

                    <input type="hidden" name="added_by" value="{{ Auth::user()->id }}">

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>اسم الموكل</label>
                            <input type="text" name="name" value="{{ old('name', $client->name) }}"
                                class="form-control">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>البريد الالكتروني</label>
                            <input type="text" name="email" value="{{ old('email', $client->user->email) }}"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>اسم الشركة</label>
                            <input type="text" id="company_name" name="company_name"
                                value="{{ old('company_name', $client->company_name) }}" class="form-control">
                        </div>

                        <div class="form-group col-md-4" id="company_national_wrapper"
                            style="{{ $client->company_name ? '' : 'display:none;' }}">
                            <label>رقم الوطني للشركة</label>
                            <input type="text" name="company_national_number"
                                value="{{ old('company_national_number', $client->company_national_number) }}"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>الرقم القومي</label>
                            <input type="text" name="national_id" value="{{ old('national_id', $client->national_id) }}"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>الجنسية</label>
                            <input type="text" name="nationality" value="{{ old('nationality', $client->nationality) }}"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>العنوان</label>
                            <input type="text" name="address" value="{{ old('address', $client->address) }}"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>الهاتف</label>
                            <input type="text" name="phone" value="{{ old('phone', $client->phone) }}"
                                class="form-control">
                        </div>
                    </div>

                    <!-- الموكلين الإضافيين -->
                    <div class="additional-clients mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>الموكلين الإضافيين</h5>
                            <button type="button" id="addClientBtn" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> إضافة موكل
                            </button>
                        </div>

                        <div id="additionalClientsContainer">
                            @foreach ($additionalClients as $index => $addClient)
                                <div class="client-group border p-3 mb-3 rounded">
                                    <div class="row">
                                        <div class="col-11">
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label>اسم الموكل</label>
                                                    <input type="text"
                                                        name="additional_clients[{{ $index }}][client_name]"
                                                        value="{{ $addClient->name }}" class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>هاتف الموكل</label>
                                                    <input type="text"
                                                        name="additional_clients[{{ $index }}][client_phone]"
                                                        value="{{ $addClient->phone }}" class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>جنسية الموكل</label>
                                                    <input type="text"
                                                        name="additional_clients[{{ $index }}][client_nationality]"
                                                        value="{{ $addClient->nationality }}" class="form-control">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>الرقم القومي</label>
                                                    <input type="text"
                                                        name="additional_clients[{{ $index }}][client_national_id]"
                                                        value="{{ $addClient->national_id }}" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>العنوان</label>
                                                    <input type="text"
                                                        name="additional_clients[{{ $index }}][client_address]"
                                                        value="{{ $addClient->address }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1 d-flex align-items-center">
                                            <button type="button" class="btn btn-danger remove-client">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const companyInput = document.getElementById("company_name");
            const nationalWrapper = document.getElementById("company_national_wrapper");
            const addClientBtn = document.getElementById("addClientBtn");
            const container = document.getElementById("additionalClientsContainer");
            let clientCount = {{ $additionalClients->count() }};

            function toggleNationalField() {
                if (companyInput.value.trim() !== "") {
                    nationalWrapper.style.display = "block";
                } else {
                    nationalWrapper.style.display = "none";
                }
            }

            companyInput.addEventListener("input", toggleNationalField);
            toggleNationalField();

            // إضافة موكل جديد
            addClientBtn.addEventListener("click", function() {
                clientCount++;
                const clientDiv = document.createElement("div");
                clientDiv.className = "client-group border p-3 mb-3 rounded";
                clientDiv.innerHTML = `
                <div class="row">
                    <div class="col-11">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label>اسم الموكل</label>
                                <input type="text" name="additional_clients[\${clientCount}][client_name]" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>هاتف الموكل</label>
                                <input type="text" name="additional_clients[\${clientCount}][client_phone]" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>جنسية الموكل</label>
                                <input type="text" name="additional_clients[\${clientCount}][client_nationality]" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>الرقم القومي</label>
                                <input type="text" name="additional_clients[\${clientCount}][client_national_id]" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>العنوان</label>
                                <input type="text" name="additional_clients[\${clientCount}][client_address]" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-1 d-flex align-items-center">
                        <button type="button" class="btn btn-danger remove-client">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
                container.appendChild(clientDiv);

                // حذف الموكل
                const removeBtn = clientDiv.querySelector(".remove-client");
                removeBtn.addEventListener("click", function() {
                    container.removeChild(clientDiv);
                });
            });

            // تفعيل زرار الحذف للموجودين بالفعل
            document.querySelectorAll(".remove-client").forEach(btn => {
                btn.addEventListener("click", function() {
                    btn.closest(".client-group").remove();
                });
            });
        });
    </script>
@endsection

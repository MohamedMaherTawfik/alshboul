@extends('layouts.admin')
@section('title', 'الموكلين ')
@section('main_title_content', ' قائمة الموكلين ')
@section('title_content', 'أضافة')
@section('link_content')
    <a href="{{ route('client.index') }}"> موكلين</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center"> اضافة موكل جديد
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('client.store') }}" method="post" id="clientForm">
                    @csrf
                    <input type="hidden" name="added_by" value="{{ Auth::user()->id }}">

                    <div class="row ">
                        <div class="form-group col-md-4">
                            <label for="">اسم الموكل </label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                placeholder="">
                            @error('name')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">البريد الالكتروني</label>
                            <input type="text" id="email" name="email" value="{{ old('email') }}"
                                class="form-control" placeholder="">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="">الرقم السري</label>
                            <input type="password" id="password" name="password" value="{{ old('password') }}"
                                class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">اسم الشركة </label>
                            <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                                class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4" id="company_national_wrapper" style="display: none;">
                            <label for="">رقم الوطني للشركة </label>
                            <input type="text" name="company_national_number"
                                value="{{ old('company_national_number') }}" class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> الرقم القومي </label>
                            <input type="text" name="national_id" value="{{ old('national_id') }}" class="form-control"
                                placeholder="">
                            @error('national_id')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> الجنسية </label>
                            <input type="text" name="nationality" value="{{ old('nationality') }}" class="form-control"
                                placeholder="">
                            @error('nationality')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for=""> عنوان </label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                                placeholder="">
                            @error('address')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">هاتف </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                placeholder="">
                            @error('phone')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <!-- قسم الموكلين الإضافيين -->
                    <div class="additional-clients mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>الموكلين الإضافيين</h5>
                            <button type="button" id="addClientBtn" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> إضافة موكل
                            </button>
                        </div>

                        <div id="additionalClientsContainer">
                            <!-- سيتم إضافة الحقول الجديدة هنا -->
                        </div>
                    </div>

                    <hr>

                    <div class="text-center col-md-12 mt-4">
                        <button type="submit" class="btn btn-success">أضافة</button>
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
            let clientCount = 0;

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
                                <label for="client_name_${clientCount}">اسم الموكل</label>
                                <input type="text" name="additional_clients[${clientCount}][client_name]"
                                    class="form-control" id="client_name_${clientCount}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="client_phone_${clientCount}">هاتف الموكل</label>
                                <input type="text" name="additional_clients[${clientCount}][client_phone]"
                                    class="form-control" id="client_phone_${clientCount}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="client_nationality_${clientCount}">جنسية الموكل</label>
                                <input type="text" name="additional_clients[${clientCount}][client_nationality]"
                                    class="form-control" id="client_nationality_${clientCount}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="client_national_id_${clientCount}">الرقم القومي</label>
                                <input type="text" name="additional_clients[${clientCount}][client_national_id]"
                                    class="form-control" id="client_national_id_${clientCount}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="client_address_${clientCount}">عنوان الموكل</label>
                                <input type="text" name="additional_clients[${clientCount}][client_address]"
                                    class="form-control" id="client_address_${clientCount}">
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

                // إضافة حدث لإزالة الموكل
                const removeBtn = clientDiv.querySelector(".remove-client");
                removeBtn.addEventListener("click", function() {
                    container.removeChild(clientDiv);
                });
            });
        });
    </script>
@endsection

<style>
    .client-group {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .client-group:hover {
        background-color: #e9ecef;
    }

    .remove-client {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>

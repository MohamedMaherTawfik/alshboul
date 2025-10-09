@extends('layouts.admin')
@section('title', 'الموكلين')
@section('main_title_content', 'قائمة الموكلين')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('client.index') }}">موكلين</a>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">إضافة موكل جديد</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('client.store') }}" method="post" id="clientForm">
                    @csrf
                    <input type="hidden" name="added_by" value="{{ Auth::user()->id }}">

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>اسم الموكل</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>البريد الإلكتروني</label>
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>الرقم السري</label>
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>الرقم الوطني</label>
                            <input type="text" name="national_id" value="{{ old('national_id') }}" class="form-control">
                            @error('national_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>الجنسية</label>
                            <input type="text" name="nationality" value="{{ old('nationality') }}" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>العنوان</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>هاتف</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
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

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success">إضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addClientBtn = document.getElementById("addClientBtn");
            const container = document.getElementById("additionalClientsContainer");
            let clientCount = 0;

            if (addClientBtn && container) {
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
                                <input type="text" name="additional_clients[${clientCount}][client_name]" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>هاتف الموكل</label>
                                <input type="text" name="additional_clients[${clientCount}][client_phone]" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>جنسية الموكل</label>
                                <input type="text" name="additional_clients[${clientCount}][client_nationality]" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>الرقم الوطني</label>
                                <input type="text" name="additional_clients[${clientCount}][client_national_id]" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>عنوان الموكل</label>
                                <input type="text" name="additional_clients[${clientCount}][client_address]" class="form-control">
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

                    // زر الحذف
                    const removeBtn = clientDiv.querySelector(".remove-client");
                    removeBtn.addEventListener("click", function() {
                        clientDiv.remove();
                    });
                });
            }
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

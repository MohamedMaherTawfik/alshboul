@extends('layouts.admin')
@section('title', 'تعديل الموكل')
@section('main_title_content', 'تعديل بيانات الموكل')
@section('link_content')
    <a href="{{ route('client.index') }}">موكلين</a>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">تعديل بيانات الموكل</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('client.update', $client->id) }}" method="post" id="clientForm">
                    @csrf
                    @method('PUT')

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
                            <label>البريد الإلكتروني</label>
                            <input type="text" name="email" value="{{ old('email', $client->user->email ?? '') }}"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>اسم الدخول</label>
                            <input type="text" name="username"
                                value="{{ old('username', $client->user->username ?? '') }}" class="form-control">
                            @error('username')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label>كلمة المرور (اتركها فارغة إذا لا تريد تغييرها)</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                            <label>الرقم الوطني</label>
                            <input type="text" name="national_id" value="{{ old('national_id', $client->national_id) }}"
                                class="form-control">
                            @error('national_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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
                            <label>هاتف</label>
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
                                                    <label>الرقم الوطني</label>
                                                    <input type="text"
                                                        name="additional_clients[{{ $index }}][client_national_id]"
                                                        value="{{ $addClient->national_id }}" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>عنوان الموكل</label>
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
            const addClientBtn = document.getElementById("addClientBtn");
            const container = document.getElementById("additionalClientsContainer");
            let clientCount = {{ $additionalClients->count() }};

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
                                <label>الرقم الوطني</label>
                                <input type="text" name="additional_clients[\${clientCount}][client_national_id]" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>عنوان الموكل</label>
                                <input type="text" name="additional_clients[\${clientCount}][client_address]" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-1 d-flex align-items-center">
                        <button type="button" class="btn btn-danger remove-client">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>`;
                container.appendChild(clientDiv);

                // حذف الموكل الجديد
                clientDiv.querySelector(".remove-client").addEventListener("click", function() {
                    clientDiv.remove();
                });
            });

            // حذف الموكلين الموجودين مسبقاً
            document.querySelectorAll(".remove-client").forEach(btn => {
                btn.addEventListener("click", function() {
                    btn.closest(".client-group").remove();
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

@extends('layouts.admin')

@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('executive-case.index', $executiveCase->excutive_cases_main_id) }}">قضايا تنفيذية</a>
@endsection

@section('content')
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">تعديل قضية تنفيذية</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('executive-case.update', $executiveCase) }}">
                    @csrf
                    <div class="row g-3">

                        <!-- رقم المشترك -->
                        <div class="col-md-6">
                            <label for="subscriber_number">رقم المشترك</label>
                            <input type="text" id="subscriber_number" name="subscriber_number"
                                class="form-control @error('subscriber_number') is-invalid @enderror"
                                value="{{ old('subscriber_number', $executiveCase->subscriber_number) }}" readonly>
                            @error('subscriber_number')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- المشترك -->
                        <div class="col-md-6">
                            <label for="user_id">المشترك</label>
                            <input type="text" class="form-control"
                                value="{{ old('subscriber_number', $executiveCase->client?->name) }}" readonly>
                        </div>

                        <!-- الموكل -->
                        <div class="col-md-6">
                            <label for="client_name">الموكل</label>
                            <select id="client_name" name="client_name"
                                class="form-control @error('client_name') is-invalid @enderror">
                                @foreach ($clients->where('user_id', $executiveCase->client?->user_id) as $c)
                                    <option value="{{ $c->name }}" data-national-id="{{ $c->national_id }}"
                                        {{ $executiveCase->client_name == $c->name ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- الرقم الوطني للموكل -->
                        <div class="col-md-6">
                            <label for="client_national_id">الرقم الوطني للموكل</label>
                            <input type="text" id="client_national_id" name="client_national_id"
                                class="form-control @error('client_national_id') is-invalid @enderror"
                                value="{{ old('client_national_id', $executiveCase->client_national_id) }}" readonly>
                            @error('client_national_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- اسم الخصم -->
                        <div class="col-md-6">
                            <label>اسم الخصم</label>
                            <input type="text" name="opponent_name" class="form-control"
                                value="{{ old('opponent_name', $executiveCase->opponent_name) }}">
                        </div>

                        <!-- الرقم الوطني للخصم -->
                        <div class="col-md-6">
                            <label>الرقم الوطني للخصم</label>
                            <input type="text" name="opponent_national_id" class="form-control"
                                value="{{ old('opponent_national_id', $executiveCase->opponent_national_id) }}">
                        </div>

                        <!-- أرقام الملفات -->
                        @php
                            use App\Models\excutiveCasesMain;
                            $main = excutiveCasesMain::all();
                        @endphp
                        <div class="col-md-4">
                            <label for="executiveCase">نوع القضية التنفيذية بالسيستم</label>
                            <select id="executiveCase" name="excutive_cases_main_id"
                                class="form-control @error('executiveCase') is-invalid @enderror">
                                @foreach ($main as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $executiveCase->executiveCase_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('executiveCase')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label>رقم الدعوى</label>
                            <input type="text" name="case_number" class="form-control"
                                value="{{ old('case_number', $executiveCase->case_number) }}">
                        </div>

                        <div class="col-md-4">
                            <label>رقم الملف</label>
                            <input type="text" name="file_number" class="form-control"
                                value="{{ old('file_number', $executiveCase->file_number) }}" readonly>
                        </div>

                        <!-- باقي الحقول -->
                        <div class="col-md-6">
                            <label>نوع القضية التنفيذية</label>
                            <input type="text" name="case_type" class="form-control"
                                value="{{ old('case_type', $executiveCase->case_type) }}">
                        </div>

                        <div class="col-md-6">
                            <label>حالة القضية</label>
                            <input type="text" name="case_status" class="form-control"
                                value="{{ old('case_status', $executiveCase->case_status) }}">
                        </div>

                        <div class="col-md-6">
                            <label>قيمة الدعوى</label>
                            <input type="number" step="0.01" name="case_value" class="form-control"
                                value="{{ old('case_value', $executiveCase->case_value) }}">
                        </div>

                        <div class="col-md-6">
                            <label>الدائرة التنفيذية</label>
                            <input type="text" name="execution_court" class="form-control"
                                value="{{ old('execution_court', $executiveCase->execution_court) }}">
                        </div>

                        <div class="col-md-6">
                            <label>نوع السند التنفيذي</label>
                            <input type="text" name="execution_document_type" class="form-control"
                                value="{{ old('execution_document_type', $executiveCase->execution_document_type) }}">
                        </div>

                        <div class="col-md-6">
                            <label>صفة المحكوم له</label>
                            <input type="text" name="judged_for_status" class="form-control"
                                value="{{ old('judged_for_status', $executiveCase->judged_for_status) }}">
                        </div>

                        <div class="col-md-6">
                            <label>صفة المحكوم عليه</label>
                            <input type="text" name="judged_against_status" class="form-control"
                                value="{{ old('judged_against_status', $executiveCase->judged_against_status) }}">
                        </div>

                        <div class="col-md-6">
                            <label>تاريخ التسجيل</label>
                            <input type="date" name="registration_date" class="form-control"
                                value="{{ old('registration_date', $executiveCase->registration_date) }}">
                        </div>

                        <div class="col-md-6">
                            <label>رقم السند التنفيذي</label>
                            <input type="text" name="execution_document_number" class="form-control"
                                value="{{ old('execution_document_number', $executiveCase->execution_document_number) }}">
                        </div>

                        <div class="col-md-6">
                            <label>تاريخ الجلسة الإجرائية</label>
                            <input type="date" name="procedural_session_date" class="form-control"
                                value="{{ old('procedural_session_date', $executiveCase->procedural_session_date) }}">
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-success px-4">💾 تحديث القضية</button>
                        <a href="{{ route('executive-case.index', $executiveCase->excutive_cases_main_id) }}"
                            class="btn btn-secondary px-4">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

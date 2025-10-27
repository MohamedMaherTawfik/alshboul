@extends('layouts.admin')

@section('title', 'القضايا التنفيذية')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')

@section('content')
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h4 class="text-center mb-4 fw-bold text-primary">تعديل القضية التنفيذية</h4>

            <form action="{{ route('executive-case.update', $executiveCase->id) }}" method="POST">
                @csrf

                {{-- بيانات العميل --}}
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">اسم العميل</label>
                        <input type="text" name="client_name" value="{{ old('client_name', $executiveCase->client_name) }}"
                            class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الرقم القومي للعميل</label>
                        <input type="text" name="client_national_id"
                            value="{{ old('client_national_id', $executiveCase->client_national_id) }}"
                            class="form-control">
                    </div>
                </div>

                {{-- بيانات الخصوم --}}
                <div class="mb-4">
                    <label class="form-label">الخصوم</label>
                    <div id="opponents-wrapper">
                        @foreach ($executiveCase->opponents as $index => $opponent)
                            <div class="opponent-item row g-2 mb-2">
                                <div class="col-md-5">
                                    <input type="text" name="opponents[{{ $index }}][name]"
                                        value="{{ $opponent->case_opponent_name }}" class="form-control"
                                        placeholder="اسم الخصم">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="opponents[{{ $index }}][national_id]"
                                        value="{{ $opponent->case_opponent_national_number }}" class="form-control"
                                        placeholder="الرقم القومي للخصم">
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-danger remove-opponent w-100">
                                        <i class="bi bi-x-lg"></i> حذف
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" id="add-opponent" class="btn btn-outline-primary mt-2">
                        <i class="bi bi-plus-lg"></i> إضافة خصم
                    </button>
                </div>

                {{-- بيانات القضية --}}
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">نوع القضية التنفيذية</label>
                        <select name="excutive_cases_main_id" class="form-select" required>
                            @foreach ($mainCases as $main)
                                <option value="{{ $main->id }}"
                                    {{ $executiveCase->excutive_cases_main_id == $main->id ? 'selected' : '' }}>
                                    {{ $main->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم القضية</label>
                        <input type="text" name="case_number"
                            value="{{ old('case_number', $executiveCase->case_number) }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">نوع القضية</label>
                        <input type="text" name="case_type" value="{{ old('case_type', $executiveCase->case_type) }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">حالة القضية</label>
                        <input type="text" name="case_status"
                            value="{{ old('case_status', $executiveCase->case_status) }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">قيمة القضية</label>
                        <input type="number" step="0.01" name="case_value"
                            value="{{ old('case_value', $executiveCase->case_value) }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">محكمة التنفيذ</label>
                        <input type="text" name="execution_court"
                            value="{{ old('execution_court', $executiveCase->execution_court) }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">نوع السند التنفيذي</label>
                        <input type="text" name="execution_document_type"
                            value="{{ old('execution_document_type', $executiveCase->execution_document_type) }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحكم لصالح</label>
                        <input type="text" name="judged_for_status"
                            value="{{ old('judged_for_status', $executiveCase->judged_for_status) }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الحكم ضد</label>
                        <input type="text" name="judged_against_status"
                            value="{{ old('judged_against_status', $executiveCase->judged_against_status) }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ التسجيل</label>
                        <input type="date" name="registration_date"
                            value="{{ old('registration_date', $executiveCase->registration_date) }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم السند التنفيذي</label>
                        <input type="text" name="execution_document_number"
                            value="{{ old('execution_document_number', $executiveCase->execution_document_number) }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ الجلسة الإجرائية</label>
                        <input type="date" name="procedural_session_date"
                            value="{{ old('procedural_session_date', $executiveCase->procedural_session_date) }}"
                            class="form-control">
                    </div>
                </div>

                {{-- أزرار التحكم --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('executive-case.index', $executiveCase->excutive_cases_main_id) }}"
                        class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i> رجوع
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript لإدارة الخصوم --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.getElementById('opponents-wrapper');
            const addBtn = document.getElementById('add-opponent');

            addBtn.addEventListener('click', () => {
                const index = wrapper.children.length;
                const div = document.createElement('div');
                div.classList.add('opponent-item', 'row', 'g-2', 'mb-2');
                div.innerHTML = `
                <div class="col-md-5">
                    <input type="text" name="opponents[${index}][name]" class="form-control" placeholder="اسم الخصم">
                </div>
                <div class="col-md-5">
                    <input type="text" name="opponents[${index}][national_id]" class="form-control" placeholder="الرقم القومي للخصم">
                </div>
                <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-outline-danger remove-opponent w-100">
                        <i class="bi bi-x-lg"></i> حذف
                    </button>
                </div>
            `;
                wrapper.appendChild(div);
            });

            wrapper.addEventListener('click', e => {
                if (e.target.closest('.remove-opponent')) {
                    e.target.closest('.opponent-item').remove();
                }
            });
        });
    </script>
@endsection

@extends('layouts.admin')
@section('title', 'تعديل الجلسة')
@section('main_title_content', 'تعديل الجلسة')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('cases.all') }}"> جميع القضايا</a>
@endsection

<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --accent-color: #e74c3c;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        border: none;
    }

    .card-header {
        background-color: var(--primary-color);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }

    .btn-primary {
        background-color: var(--secondary-color);
        border: none;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    .required-field::after {
        content: " *";
        color: var(--accent-color);
    }

    .form-label {
        font-weight: 500;
    }

    .page-title {
        color: var(--primary-color);
        border-right: 4px solid var(--secondary-color);
        padding-right: 15px;
    }
</style>

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col">
                <h2 class="page-title">تعديل جلسة قضائية</h2>
                <p class="text-muted">قم بتعديل تفاصيل الجلسة القضائية</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-3">
                <h5 class="card-title mb-0"><i class="bi bi-calendar-event me-2"></i>تفاصيل الجلسة</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('cases.session.update', $session->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="type" value="جلسه">

                    <!-- معلومات القضية (عرض فقط) -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body py-3">
                                    <h6 class="card-title"><i class="bi bi-folder me-2"></i>معلومات القضية</h6>
                                    <p class="mb-0">رقم القضية: {{ $session->cases->case_number ?? 'غير محدد' }}</p>
                                    <p class="mb-0">اسم الموكل: {{ $session->cases->client->name ?? 'غير محدد' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $isLessThan48 = false;
                        if ($session->date) {
                            $date = \Carbon\Carbon::parse($session->date);
                            $hoursDiff = now()->diffInHours($date, false); // false عشان يرجع بالسالب لو التاريخ فات
                            $isLessThan48 = $hoursDiff >= 0 && $hoursDiff <= 48;
                        }
                    @endphp

                    <!-- التاريخ -->
                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label required-field">تاريخ الجلسة</label>
                        <input type="date"
                            class="form-control {{ $isLessThan48 ? 'border border-danger text-danger fw-bold' : '' }}"
                            id="date" name="date"
                            value="{{ $session->date ? \Carbon\Carbon::parse($session->date)->format('Y-m-d') : '' }}"
                            required>
                    </div>

                    <!-- المحامي -->
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label required-field">المحامي</label>
                        <select class="form-select" id="user_id" name="user_id">
                            <option value="{{ $session->lawyer_user->id ?? null }}">
                                {{ $session->lawyer_user->name ?? 'غير محدد' }}</option>
                            @foreach ($lawers as $lawyer)
                                <option value="{{ $lawyer->id }}"
                                    {{ $session->lawyer_id == $lawyer->id ? 'selected' : '' }}>
                                    {{ $lawyer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- الوقائع -->
                    <div class="mb-3">
                        <label for="facts" class="form-label required-field">وقائع الجلسة</label>
                        <textarea class="form-control" id="facts" name="facts" rows="4" required>{{ $session->facts ?? '' }}</textarea>
                    </div>

                    <!-- ملاحظات -->
                    <div class="mb-4">
                        <label for="note" class="form-label">ملاحظات</label>
                        <textarea class="form-control" id="note" name="note" rows="3">{{ $session->note ?? '' }}</textarea>
                    </div>

                    <!-- أزرار -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('cases.show', $session->cases->id) }}" class="btn btn-secondary">رجوع</a>
                        <button type="submit" class="btn btn-primary">تحديث الجلسة</button>
                    </div>
                </form>

                <div class="row">
                    <!-- ملف مرفق -->
                    <div class="col-md-12 mb-3">
                        @if ($session->sessionFiles->count() > 0)
                            <p class="fw-bold mb-2">الملفات الحالية:</p>
                            @foreach ($session->sessionFiles as $file)
                                <div class="mb-2">
                                    <!-- زر عرض -->
                                    <a href="{{ asset('storage/' . $file->file) }}" class="btn btn-sm btn-info"
                                        target="_blank">
                                        عرض المستند
                                    </a>

                                    <!-- زر الحذف -->
                                    <form action="{{ route('cases.session.delete.files', $file->id) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من الحذف؟')" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">لا توجد ملفات مرفقة حالياً.</p>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

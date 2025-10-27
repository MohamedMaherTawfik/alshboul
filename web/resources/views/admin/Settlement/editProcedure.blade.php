@extends('layouts.admin')

@section('title', 'تعديل سجل إجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('procedural-record.index', $settlement) }}">السجلات الإجرائية</a>
@endsection

@section('content')
    <div class="container my-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-dark text-white text-center fw-bold">
                تعديل إجراء
            </div>
            <div class="card-body p-4">
                <form action="{{ route('settlement.procedural.update', $settlement) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">



                        <!-- تاريخ الإجراء -->
                        <div class="col-md-6">
                            <label for="date" class="form-label fw-bold">تاريخ الادخال</label>
                            <input type="date" name="created_at" id="created_at" class="form-control"
                                value="{{ $settlement->created_at->format('Y-m-d') }}">
                        </div>

                        <!-- الإجراء -->
                        <div class="col-12">
                            <label for="action" class="form-label fw-bold">الإجراء</label>
                            <input type="text" name="action" id="action" class="form-control"
                                value="{{ old('action', $settlement->action) }}">
                        </div>

                        <!-- ملاحظة -->
                        <div class="col-12">
                            <label for="note" class="form-label fw-bold">ملاحظة</label>
                            <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', $settlement->note) }}</textarea>
                        </div>

                        <!-- المحامي -->
                        <div class="col-12">
                            <label for="user_id" class="form-label fw-bold">المحامي</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">اختر المحامي</option>
                                @foreach ($lawyers as $lawyer)
                                    <option value="{{ $lawyer->id }}"
                                        {{ old('user_id', $settlement->user_id) == $lawyer->id ? 'selected' : '' }}>
                                        {{ $lawyer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- زر التحديث -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('procedural-record.index', $settlement) }}" class="btn btn-secondary">رجوع</a>
                        <button type="submit" class="btn btn-dark px-4">تحديث</button>
                    </div>
                </form>

                <!-- الملفات الحالية -->
                @if ($settlement->files && $settlement->files->count())
                    <div class="mt-4">
                        <p class="fw-bold">المستندات الحالية:</p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($settlement->files as $file)
                                <div class="d-flex align-items-center border rounded p-2">
                                    <!-- زر العرض -->
                                    <a href="{{ asset('storage/' . $file->file_path) }}"
                                        class="btn btn-sm btn-outline-primary me-2" target="_blank">
                                        عرض المستند
                                    </a>
                                    <!-- زر الحذف -->
                                    <form action="{{ route('settlements.files.destroy', $file) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">🗑️ حذف</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

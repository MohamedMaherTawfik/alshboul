@extends('layouts.admin')

@section('title', 'تعديل سجل إجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('procedural-record.index', $case) }}">السجلات الجرائية </a>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark text-center">
                        <h4>تعديل الإجراء</h4>
                    </div>
                    <div class="card-body">

                        {{-- فورم التعديل --}}
                        <form action="{{ route('cases.procedure.update', $case) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- نوع الإجراء -->
                            <div class="mb-3">
                                <label for="type" class="form-label">نوع الإجراء</label>
                                <input type="text" name="type" id="type" class="form-control" value="اجراء">
                            </div>

                            <!-- نوع الإجراء -->

                            <div class="mb-3">
                                <label for="type" class="form-label">تاريخ الجلسه</label>
                                <input type="date" name="date" id="type" class="form-control"
                                    value="{{ old('date', $case->date) }}">
                            </div>

                            <!-- الإجراء -->
                            <div class="mb-3">
                                <label for="action" class="form-label">الإجراء</label>
                                <input type="text" name="action" id="action" class="form-control"
                                    value="{{ old('action', $case->action) }}">
                            </div>
                            <!-- ملاحظة -->
                            <div class="mb-3">
                                <label for="note" class="form-label">ملاحظة</label>
                                <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', $case->note) }}</textarea>
                            </div>

                            <!-- المحامي -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label">المحامي</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">اختر المحامي</option>
                                    @foreach ($lawyers as $lawyer)
                                        <option value="{{ $lawyer->id }}"
                                            {{ old('user_id', $case->user_id) == $lawyer->id ? 'selected' : '' }}>
                                            {{ $lawyer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- زر الحفظ -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning">تحديث</button>
                            </div>
                        </form>

                        <!-- الملفات الحالية (خارج فورم التحديث) -->
                        @if ($case->files && $case->files->count())
                            <div class="mt-4">
                                <p>الملفات الحالية:</p>
                                @foreach ($case->files as $file)
                                    <div class="mb-2 d-flex align-items-center">
                                        <!-- زر عرض -->
                                        <a href="{{ asset('storage/' . $file->file_path) }}"
                                            class="btn btn-sm btn-info me-2" target="_blank">
                                            عرض المستند
                                        </a>

                                        <!-- زر الحذف -->
                                        <form action="{{ route('cases.procedure.file.delete', $file->id) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من الحذف؟')" class="mr-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

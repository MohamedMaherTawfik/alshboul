@extends('layouts.admin')

@section('title', 'تعديل سجل إجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('procedural-record.index', $settlement) }}">السجلات الإجرائية</a>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white text-center">
                        <h4>تعديل إجراء</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('settlement.procedural.update', $settlement) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- نوع الإجراء -->
                            <div class="mb-3">
                                <label for="type" class="form-label">نوع الإجراء</label>
                                <input type="text" name="type" id="type" class="form-control"
                                    value="{{ old('type', $settlement->type) }}">
                            </div>

                            <!-- تاريخ الإجراء -->
                            <div class="mb-3">
                                <label for="date" class="form-label">تاريخ الإجراء</label>
                                <input type="date" name="date" id="date" class="form-control"
                                    value="{{ $settlement->date }}">
                            </div>

                            <!-- الإجراء -->
                            <div class="mb-3">
                                <label for="action" class="form-label">الإجراء</label>
                                <input type="text" name="action" id="action" class="form-control"
                                    value="{{ old('action', $settlement->action) }}">
                            </div>

                            <!-- ملاحظة -->
                            <div class="mb-3">
                                <label for="note" class="form-label">ملاحظة</label>
                                <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', $settlement->note) }}</textarea>
                            </div>

                            <!-- المحامي -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label">المحامي</label>
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

                            <!-- زر التحديث -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-warning">تحديث</button>
                            </div>
                        </form>
                        <!-- رفع الملفات -->
                        <div class="mb-3">
                            @if ($settlement->files && $settlement->files->count())
                                <div class="mt-3">
                                    <p class="fw-bold">المستندات الحالية:</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($settlement->files as $file)
                                            <div class="d-flex align-items-center border rounded p-2">
                                                <a href="{{ asset('storage/' . $file->file_path) }}"
                                                    class="btn btn-sm btn-outline-primary me-2" target="_blank">
                                                    📄 مستند
                                                </a>
                                                <form action="{{ route('settlements.files.destroy', $file) }}"
                                                    method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')"
                                                    class="mr-2">
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
            </div>
        </div>
    </div>
@endsection

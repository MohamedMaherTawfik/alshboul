@extends('layouts.admin')
@section('title', ' تفاصيل السجل الإجرائي')
@section('main_title_content', 'قائمة القضايا التنفيذية')
@section('title_content', 'تعديل')
@section('content')

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"> تعديل الإجراء</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('procedural-record.update', $executiveCase) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="card shadow-sm border-0 p-4">
                    <div class="row g-3">

                        <!-- النوع -->
                        <div class="col-md-6">
                            <label class="form-label">النوع</label>
                            <input type="text" class="form-control" value="{{ $executiveCase->type ?? 'إجراء' }}">
                        </div>

                        <!-- تاريخ الإجراء -->
                        <div class="col-md-6">
                            <label for="date" class="form-label required-field">تاريخ الجلسه</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ $executiveCase->date }}">
                        </div>

                        <!-- تاريخ الإدخال -->
                        <div class="col-md-6">
                            <label for="created_at" class="form-label required-field">تاريخ الإدخال</label>
                            <input type="date" class="form-control" id="created_at" name="created_at"
                                value="{{ now()->format('Y-m-d') }}" value="{{ $executiveCase->created_at }}">
                        </div>

                        <!-- الإجراء القادم -->
                        <div class="col-md-6">
                            <label for="next_action" class="form-label">الإجراء القادم</label>
                            <input type="text" class="form-control" id="next_action" name="next_action"
                                value="{{ $executiveCase->next_action }}">
                        </div>

                        <!-- تاريخ الإجراء القادم -->
                        <div class="col-md-6 mt-1">
                            <label for="next_action_date" class="form-label">تاريخ الإجراء القادم</label>
                            <input type="date" class="form-control" id="next_action_date" name="next_action_date"
                                value="{{ $executiveCase->next_action_date }}">
                        </div>

                        <!-- المحامي -->
                        <div class="col-md-6">
                            <label for="user_id" class="form-label required-field mt-5">المحامي</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="{{ $executiveCase->user_id ?? '' }}" selected disabled>
                                    {{ $executiveCase->user->name ?? '' }}</option>
                                @foreach ($lawyers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- تفاصيل الإجراء -->
                        <div class="col-12">
                            <label for="action" class="form-label required-field">تفاصيل الإجراء</label>
                            <input type="imput" class="form-control" id="action" name="action" rows="4"
                                value="{{ $executiveCase->action }}"></input>
                        </div>

                        <!-- ملاحظات -->
                        <div class="col-12">
                            <label for="note" class="form-label">ملاحظات</label>
                            <input type="text" class="form-control" id="note" name="note" rows="3"
                                value="{{ $executiveCase->note }}"></input>
                        </div>
                        <!-- الأزرار -->
                        <div class="col-12 d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-primary px-4">تحديث</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">إلغاء</a>
                        </div>
                    </div>
                </div>
            </form>

            @if ($executiveCase->files->count() > 0)
                <div class="col-md-12 mb-3 mt-4">
                    <p class="fw-bold"> الملفات الحالية:</p>
                    <ul class="list-group">
                        @foreach ($executiveCase->files as $file)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">عرض الملف</a>
                                <form action="{{ route('procedural-executiveCase.file.destroy', $file->id) }}"
                                    method="POST" onsubmit="return confirm('حذف هذا الملف؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
    </div>

@endsection

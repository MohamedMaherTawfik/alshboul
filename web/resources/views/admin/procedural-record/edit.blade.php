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

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">النوع</label>
                        <input type="text" name="type" class="form-control"
                            value="{{ $executiveCase->type ?? 'اجراء' }}" readonly>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">الإجراء</label>
                        <textarea name="action" class="form-control" rows="4" required>{{ $executiveCase->action }}</textarea>
                    </div>


                    <div class="col-md-12 mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="note" class="form-control">{{ $executiveCase->note }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">اجراء قادم</label>
                        <textarea name="next_action" class="form-control">{{ $executiveCase->next_action }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">تاريخ الاجراء القادم </label>
                        <input type="date" name="next_action_date" value="{{ $executiveCase->next_action_date }}"
                            class="form-control"></input>
                    </div>


                    <div class="col-md-6 mb-3">
                        <label class="form-label">المحامي</label>
                        <select name="user_id" class="form-select">
                            <option value="">-- اختر المحامي --</option>
                            @foreach ($lawyers as $lawyer)
                                <option value="{{ $lawyer->id }}" @selected($executiveCase->user_id == $lawyer->id)>
                                    {{ $lawyer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">إلغاء</a>
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

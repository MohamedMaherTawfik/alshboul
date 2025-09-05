@extends('layouts.admin')
@section('title', 'تعديل الإجراء')
@section('main_title_content', 'تعديل الإجراء')
@section('title_content', 'تعديل')
{{--
@section('link_content')
    <a href="{{ route('transactions.show', $transaction->id) }}">رجوع للمعاملة</a>
@endsection --}}

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">تعديل الإجراء - ({{ $transaction->name ?? '-' }})</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('transactions.procedural.update', $transaction->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">النوع</label>
                        <input type="text" name="type" class="form-control" readonly value="اجراء">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الإجراء</label>
                        <textarea name="action" class="form-control" rows="2" required>{{ $transaction->action }}</textarea>
                        @error('action')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الملاحظات</label>
                        <textarea name="note" class="form-control" rows="2">{{ $transaction->note }}</textarea>
                        @error('note')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">المحامي المسئول</label>
                        <select name="user_lawyer_id" class="form-control" required>
                            <option value="">-- اختر المحامي --</option>
                            @foreach (\App\Models\User::whereIn('role', ['Lawyer', 'admin', 'superadmin'])->get() as $lawyer)
                                <option value="{{ $lawyer->id }}"
                                    {{ $transaction->user_lawyer_id == $lawyer->id ? 'selected' : '' }}>
                                    {{ $lawyer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_lawyer_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                    </div>
                </form>

                @if ($transaction->files && $transaction->files->count())
                    <div class="mt-4">
                        <p>الملفات الحالية:</p>
                        @foreach ($transaction->files as $file)
                            <div class="mb-2 d-flex align-items-center">
                                <!-- زر عرض -->
                                <a href="{{ asset('storage/' . $file->file_path) }}" class="btn btn-sm btn-info me-2"
                                    target="_blank">
                                    عرض المستند
                                </a>

                                <!-- زر الحذف -->
                                <form action="{{ route('transactions.procedure.file.delete', $file->id) }}" method="POST"
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
@endsection

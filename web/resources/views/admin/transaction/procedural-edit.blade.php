@extends('layouts.admin')

@section('title', 'تعديل الإجراء')
@section('main_title_content', 'قائمة المعاملات')
@section('title_content', 'تعديل إجراء')


@section('content')
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white fw-bold text-center">
            تعديل الإجراء - ({{ $transaction->name ?? '-' }})
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('transactions.procedural.update', $transaction->id) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <!-- النوع -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">النوع</label>
                        <input type="text" name="type" class="form-control" readonly value="اجراء">
                    </div>

                    <!-- تاريخ الإجراء -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ الإجراء</label>
                        <input type="date" name="created_at" class="form-control"
                            value="{{ old('created_at', $transaction->created_at->format('Y-m-d')) }}">
                        @error('created_at')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- تفاصيل الإجراء -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الإجراء</label>
                        <textarea name="action" class="form-control" rows="2" required>{{ old('action', $transaction->action) }}</textarea>
                        @error('action')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- ملاحظات -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الملاحظات</label>
                        <textarea name="note" class="form-control" rows="2">{{ old('note', $transaction->note) }}</textarea>
                        @error('note')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- المحامي المسئول -->
                    <div class="col-md-6 mb-3">
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
                </div>

                <!-- الأزرار -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-success">تحديث</button>
                </div>
            </form>

            <!-- الملفات الحالية -->
            @if ($transaction->files && $transaction->files->count())
                <div class="mt-5">
                    <h5 class="fw-bold mb-3 text-center">الملفات الحالية:</h5>
                    @foreach ($transaction->files as $file)
                        <div
                            class="mb-2 d-flex justify-content-between align-items-center border p-2 rounded shadow-sm bg-light">
                            <a href="{{ asset('storage/' . $file->file_path) }}" class="btn btn-sm btn-info"
                                target="_blank">
                                عرض المستند
                            </a>
                            <form action="{{ route('transactions.procedure.file.delete', $file->id) }}" method="POST"
                                onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@extends('layouts.admin')
@section('title', 'إضافة أرشيف جديد')
@section('main_title_content', 'قائمة الأرشيف')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('archive.index') }}">الأرشيف</a>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- زر الرجوع -->
        <a href="{{ route('archive.index') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> رجوع
        </a>

        <!-- كرت النموذج -->
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus-circle"></i> إضافة أرشيف جديد</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('archive.main.store') }}" method="POST">
                    @csrf

                    <!-- حقل الاسم -->
                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم *</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            placeholder="أدخل اسم الأرشيف" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- حقل مخفي لـ user_id -->
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <!-- زر الإرسال -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save"></i> حفظ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

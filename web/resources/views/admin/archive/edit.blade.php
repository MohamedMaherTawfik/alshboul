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
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">إضافة أرشيف جديد</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('archive.update', $archive) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- الاسم -->
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم *</label>
                            <input type="text" name="name" id="name" value="{{ $archive->name }}"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="أدخل اسم الأرشيف">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- قائمة منسدلة -->
                        <div class="mb-3">
                            <label for="sub_menu_id" class="form-label">اختر نوع الأرشيف *</label>
                            <select name="sub_menu_id" id="sub_menu_id"
                                class="form-select @error('sub_menu_id') is-invalid @enderror">
                                <option value="{{ $archive->sub_menu_id }}" disabled selected>-- اختر من القائمة --</option>
                                @foreach ($archivesSubMenues as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                @endforeach
                            </select>
                            @error('sub_menu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- رفع ملف -->
                        <div class="mb-3">
                            <label for="file" class="form-label">اختر ملف *</label>
                            <input type="file" name="file" id="file"
                                class="form-control @error('file') is-invalid @enderror">
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- الملاحظة -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">الاسم *</label>
                            <input type="text" name="notes" id="notes" value="{{ $archive->notes }}"
                                class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes') }}"
                                placeholder="أدخل اسم الأرشيف">
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- حقل مخفي -->
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        <!-- زر الإرسال -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-2"></i> حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

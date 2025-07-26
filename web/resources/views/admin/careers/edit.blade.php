@extends('layouts.admin')
@section('title', 'الوظائف')
@section('main_title_content', 'قائمة الوظائف')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('careers.index') }}">الوظائف</a>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">تعديل الوظيفة</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('careers.update', $career->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name_ar">الاسم بالعربية</label>
                                <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                    id="name_ar" name="name_ar" value="{{ old('name_ar', $career->name_ar) }}" required>
                                @error('name_ar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name_en">الاسم بالإنجليزية</label>
                                <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                    id="name_en" name="name_en" value="{{ old('name_en', $career->name_en) }}" required>
                                @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="active">الحالة</label>
                                <select class="form-control @error('active') is-invalid @enderror" id="active"
                                    name="active" required>
                                    <option value="1" {{ $career->active ? 'selected' : '' }}>نشط</option>
                                    <option value="0" {{ !$career->active ? 'selected' : '' }}>غير نشط</option>
                                </select>
                                @error('active')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                                <a href="{{ route('careers.index') }}" class="btn btn-secondary">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

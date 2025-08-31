@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'إضافة')
@section('link_content')
    <a href="{{ route('casetypes.index') }}">أنواع القضايا</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">إضافة نوع قضية جديد</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('casetypes.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="added_by" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="com_code" value="{{ auth()->user()->com_code }}">

                    <div class="row">
                        <!-- نوع المعاملة (دروب داون) -->
                        <div class="form-group col-md-6">
                            <label for="case_type">نوع المعاملة</label>
                            <select name="case_type" id="case_type" class="form-control" required>
                                <option value="">اختر نوع المعاملة</option>
                                <option value="قضايا" {{ old('case_type') == 'قضايا' ? 'selected' : '' }}>قضايا</option>
                                <option value="قضايا تنفيذيه" {{ old('case_type') == 'قضايا تنفيذيه' ? 'selected' : '' }}>
                                    قضايا تنفيذيه</option>
                                <option value="التسويات" {{ old('case_type') == 'التسويات' ? 'selected' : '' }}>التسويات
                                </option>
                                <option value="معاملات" {{ old('case_type') == 'معاملات' ? 'selected' : '' }}>معاملات
                                </option>
                            </select>
                            @error('case_type')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- نوع أو اسم الحالة -->
                        <div class="form-group col-md-6">
                            <label for="name">نوع / اسم الحالة</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control" required>
                            @error('name')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- مدة الإهمال -->
                        <div class="form-group col-md-6">
                            <label for="days"> مدة الإهمال ان وجدت</label>
                            <input type="text" name="days" id="days" value="{{ old('days') }}"
                                class="form-control" required>
                            @error('days')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-success">إضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

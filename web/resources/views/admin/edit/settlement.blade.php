@extends('layouts.admin')
@section('title', 'أنواع القضايا')
@section('main_title_content', 'قائمة أنواع القضايا')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('casetypes.index') }}">أنواع القضايا</a>
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">تعديل نوع تسويات</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('settlements.update.new', $type) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="com_code" value="{{ auth()->user()->com_code }}">

                    <div class="row">
                        <!-- نوع المعاملة (دروب داون) -->
                        <div class="form-group col-md-6">
                            <label for="case_type">نوع المعاملة</label>
                            <input class="form-control" type="text" name="" id="" value="تسويات"
                                readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="is_active">الحالة</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="">
                                    @if ($type->is_active == 1)
                                        فعال
                                    @else
                                        مجمدة
                                    @endif
                                </option>
                                <option value="1" {{ $type->is_active == 1 ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ $type->is_active == 0 ? 'selected' : '' }}>مجمدة</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- نوع أو اسم الحالة -->
                        <div class="form-group col-md-6">
                            <label for="name">نوع / اسم الحالة</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $type->name) }}"
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
                            <input type="text" name="days" id="days"
                                value="{{ old('days', $type->NegligenceDays->first()->days ?? '') }}" class="form-control"
                                required>
                            @error('days')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

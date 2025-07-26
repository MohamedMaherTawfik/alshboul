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
                <h3 class="card-title card_title_center">تعديل نوع القضية</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('casetypes.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">الاسم بالعربية</label>
                            <input type="text" name="name_ar" value="{{ old('name_ar', $data->name_ar) }}"
                                class="form-control" required>
                            @error('name_ar')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">الاسم بالإنجليزية</label>
                            <input type="text" name="name_en" value="{{ old('name_en', $data->name_en) }}"
                                class="form-control" required>
                            @error('name_en')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">الوصف بالعربية</label>
                            <textarea name="description_ar" class="form-control" rows="4" required>{{ old('description_ar', $data->description_ar) }}</textarea>
                            @error('description_ar')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">الوصف بالإنجليزية</label>
                            <textarea name="description_en" class="form-control" rows="4" required>{{ old('description_en', $data->description_en) }}</textarea>
                            @error('description_en')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">الصورة</label>
                            @if ($data->image)
                                <div class="mb-2">
                                    <img src="{{ asset($data->image) }}" alt="Current Image"
                                        style="max-width: 100px; max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @error('image')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="text-center col-md-12">
                        <button type="submit" class="btn btn-success">تعديل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

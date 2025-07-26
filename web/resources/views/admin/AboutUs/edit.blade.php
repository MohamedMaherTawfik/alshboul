@extends('layouts.admin')
@section('title', 'من نحن')
@section('main_title_content', 'قائمة من نحن')
@section('title_content', 'تعديل')
@section('link_content')
    <a href="{{ route('aboutus.index') }}">من نحن</a>
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title card_title_center">تعديل البيانات</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('aboutus.update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                  



                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">الوصف بالعربية</label>
                            <textarea name="text_ar" class="form-control" rows="4" required>{{ old('text_ar', $data->text_ar) }}</textarea>
                            @error('text_ar')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">الوصف بالإنجليزية</label>
                            <textarea name="text_en" class="form-control" rows="4" required>{{ old('text_en', $data->text_en) }}</textarea>
                            @error('text_en')
                                <small id="helpId" class="text-muted text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">الصورة</label>
                            @if($data->image)
                                <div class="mb-2">
                                    <img src="{{ asset($data->image) }}" alt="Current Image" style="max-width: 100px; max-height: 100px;">
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
